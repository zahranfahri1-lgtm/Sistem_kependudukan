<?php

namespace App\Http\Controllers;

use App\Models\DokumenIdentitas;
use App\Models\RefModel;
use App\Models\Warga;
use App\Services\AuditService;
use App\Services\FamilyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WargaController extends Controller
{
    private function refs(): array
    {
        return [
            'jenisKelamins' => (new RefModel)->setTable('jenis_kelamin')->orderBy('id')->get(),
            'agamas' => (new RefModel)->setTable('agama')->orderBy('id')->get(),
            'statusPernikahans' => (new RefModel)->setTable('status_pernikahan')->orderBy('id')->get(),
            'pendidikans' => (new RefModel)->setTable('pendidikan_terakhir')->orderBy('id')->get(),
            'pekerjaans' => (new RefModel)->setTable('pekerjaan')->orderBy('id')->get(),
            'golonganDarahs' => (new RefModel)->setTable('golongan_darah')->orderBy('id')->get(),
            'familyRoles' => FamilyService::relationshipOptions(),
        ];
    }

    public function index(Request $request)
    {
        $isLogin = Auth::guard('admin')->check();
        if ($isLogin && $request->boolean('export')) {
            AuditService::log('EXPORT_CSV', 'Export CSV data warga');
            return response()->streamDownload(function () {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['NIK', 'Nama', 'Jenis Kelamin', 'Agama', 'Hubungan KK', 'Status', 'Alamat', 'Provinsi']);
                Warga::with(['jenisKelamin', 'agama', 'provinsi'])->orderBy('nama')->chunk(200, fn($rows) => $rows->each(fn($w) => fputcsv($out, [$w->nik, $w->nama, $w->jenisKelamin?->nama ?? '-', $w->agama?->nama ?? '-', $w->hubungan_keluarga, $w->meninggal ? 'Meninggal' : 'Hidup', $w->alamat ?? '-', $w->provinsi?->nama ?? '-'])));
                fclose($out);
            }, 'data-penduduk-' . now()->format('Ymd-His') . '.csv');
        }

        $sort = in_array($request->get('sort'), $isLogin ? ['nama', 'nik', 'created_at'] : ['nama'], true) ? $request->get('sort') : ($isLogin ? 'created_at' : 'nama');
        $dir = strtoupper((string) $request->get('dir', 'DESC')) === 'ASC' ? 'ASC' : 'DESC';

        $q = Warga::with(['jenisKelamin', 'agama', 'provinsi', 'latestKk']);
        if ($s = trim((string) $request->get('search', ''))) {
            $q->where(fn($w) => $w->where('nama', 'like', "%{$s}%")->when($isLogin, fn($x) => $x->orWhere('nik', 'like', "%{$s}%")));
        }
        if ($jk = (int) $request->get('jenis_kelamin_id')) $q->where('jenis_kelamin_id', $jk);
        if ($ag = (int) $request->get('agama_id')) $q->where('agama_id', $ag);
        if ($pr = trim((string) $request->get('provinsi', ''))) $q->whereHas('provinsi', fn($x) => $x->where('nama', 'like', "%{$pr}%"));
        if ($rt = trim((string) $request->get('rt_rw', ''))) $q->where('rt_rw', 'like', "%{$rt}%");
        if ($kk = preg_replace('/\D/', '', (string) $request->get('nomor_kk', ''))) $q->whereHas('dokumenIdentitas', fn($x) => $x->where('jenis_dokumen', 'KK')->where('nomor_dokumen', 'like', "%{$kk}%"));
        if ($isLogin) {
            if ($request->get('status_warga') === 'hidup') $q->where('meninggal', false);
            if ($request->get('status_warga') === 'meninggal') $q->where('meninggal', true);
            if ($sp = (int) $request->get('status_pernikahan_id')) $q->where('status_pernikahan_id', $sp);
        }

        return view('warga.index', array_merge(['wargas' => $q->orderBy($sort, $dir)->paginate(10)->withQueryString(), 'isLogin' => $isLogin, 'currentAdmin' => Auth::guard('admin')->user(), 'sort' => $sort, 'dir' => $dir], $this->refs()));
    }

    public function store(Request $request)
    {
        $v = $this->validateWarga($request);
        $kk = trim((string) ($v['nomor_kk'] ?? ''));
        if ($v['hubungan_keluarga'] === 'Kepala Keluarga' && $kk === '') return back()->withInput()->withErrors(['nomor_kk' => 'Nomor KK wajib diisi untuk Kepala Keluarga.']);

        DB::transaction(function () use ($v, $request, $kk) {
            if ($v['hubungan_keluarga'] === 'Kepala Keluarga' && ($old = FamilyService::currentHeadId($kk))) Warga::where('id', $old)->update(['hubungan_keluarga' => 'Anggota Keluarga']);
            $warga = Warga::create($this->buildPayload($v, $request));
            if ($kk !== '') DokumenIdentitas::create(['warga_id' => $warga->id, 'jenis_dokumen' => 'KK', 'nomor_dokumen' => $kk]);
            AuditService::log('TAMBAH', "Menambah warga: {$warga->nama}");
        });
        return redirect()->route('warga.index')->with('success', 'Data warga disimpan.');
    }

    public function show(Warga $warga)
    {
        $warga->load(['jenisKelamin', 'agama', 'statusPernikahan', 'pendidikan', 'pekerjaan', 'golonganDarah', 'kelurahan', 'kecamatan', 'kota', 'provinsi', 'latestKk']);
        return view('warga.show', compact('warga'));
    }

    public function edit(Warga $warga)
    {
        $warga->load(['kelurahan', 'kecamatan', 'kota', 'provinsi', 'latestKk']);
        return view('warga.edit', array_merge(['warga' => $warga], $this->refs()));
    }

    public function update(Request $request, Warga $warga)
    {
        $warga->load('latestKk');
        $v = $this->validateWarga($request, $warga->id);
        $kk = trim((string) ($v['nomor_kk'] ?? ''));

        DB::transaction(function () use ($v, $request, $warga, $kk) {
            if ($v['hubungan_keluarga'] === 'Kepala Keluarga' && ($old = FamilyService::currentHeadId($kk, $warga->id))) Warga::where('id', $old)->update(['hubungan_keluarga' => 'Anggota Keluarga']);
            $warga->update($this->buildPayload($v, $request));
            if ($kk === '') DokumenIdentitas::where('warga_id', $warga->id)->where('jenis_dokumen', 'KK')->delete();
            elseif ($warga->latestKk) $warga->latestKk->update(['nomor_dokumen' => $kk]);
            else DokumenIdentitas::create(['warga_id' => $warga->id, 'jenis_dokumen' => 'KK', 'nomor_dokumen' => $kk]);
            AuditService::log('EDIT', "Memperbarui warga: {$warga->nama}");
        });
        return redirect()->route('warga.show', $warga)->with('success', 'Data warga diperbarui.');
    }

    public function toggleMeninggal(Warga $warga)
    {
        $warga->update(['meninggal' => !$warga->meninggal]);
        $status = $warga->meninggal ? 'Meninggal' : 'Hidup';
        AuditService::log('STATUS_WARGA', "Ubah status {$warga->nama} menjadi {$status}");
        return back()->with('success', "Status {$warga->nama} diperbarui menjadi {$status}.");
    }

    public function destroy(Warga $warga)
    {
        AuditService::log('HAPUS', "Menghapus warga: {$warga->nama}");
        $warga->delete();
        return redirect()->route('warga.index')->with('success', 'Data warga dihapus.');
    }

    public function keluarga(string $kk)
    {
        $members = Warga::with(['jenisKelamin', 'statusPernikahan', 'kelurahan', 'kecamatan', 'kota', 'provinsi', 'latestKk'])->whereHas('latestKk', fn($q) => $q->where('nomor_dokumen', $kk))->orderByRaw("CASE WHEN hubungan_keluarga = 'Kepala Keluarga' THEN 0 ELSE 1 END")->get();
        abort_if($members->isEmpty(), 404);
        return view('keluarga.show', ['nomorKk' => $kk, 'members' => $members]);
    }

    public function showImport() { return view('warga.import'); }

    public function importCsv(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt|max:5120']);
        $h = fopen($request->file('file')->getRealPath(), 'r');
        fgetcsv($h);
        $count = 0;
        while (($row = fgetcsv($h)) !== false) {
            $nik = preg_replace('/\D/', '', (string) ($row[0] ?? ''));
            $nama = trim((string) ($row[1] ?? ''));
            if (strlen($nik) === 16 && $nama !== '' && !Warga::where('nik', $nik)->exists()) {
                Warga::create(['nik' => $nik, 'nama' => $nama, 'alamat' => trim((string) ($row[2] ?? '')), 'jenis_kelamin_id' => 1, 'agama_id' => 1]);
                $count++;
            }
        }
        fclose($h);
        AuditService::log('IMPORT_CSV', "Impor {$count} data warga");
        return back()->with('success', "{$count} data berhasil diimpor.");
    }

    public function printReport() { return view('warga.print', ['wargas' => Warga::with(['jenisKelamin', 'agama', 'kota', 'provinsi'])->orderBy('nama')->get()]); }

    private function validateWarga(Request $r, ?int $ignoreId = null): array
    {
        return $r->validate([
            'nik' => ['required', 'regex:/^\d{16}$/', Rule::unique('warga', 'nik')->ignore($ignoreId)],
            'nama' => 'required|string|max:100', 'jenis_kelamin_id' => 'required|exists:jenis_kelamin,id', 'agama_id' => 'required|exists:agama,id',
            'rt_rw' => 'nullable|max:15', 'tanggal_lahir' => 'nullable|date', 'nomor_kk' => ['nullable', 'regex:/^\d{16}$/'],
            'hubungan_keluarga' => ['required', Rule::in(FamilyService::relationshipOptions())],
            'tempat_lahir' => 'nullable|max:100', 'status_pernikahan_id' => 'nullable|exists:status_pernikahan,id',
            'pendidikan_id' => 'nullable|exists:pendidikan_terakhir,id', 'pekerjaan_id' => 'nullable|exists:pekerjaan,id',
            'golongan_darah_id' => 'nullable|exists:golongan_darah,id', 'alamat' => 'nullable|string',
            'kelurahan' => 'nullable|max:100', 'kecamatan' => 'nullable|max:100', 'kota' => 'nullable|max:100', 'provinsi' => 'nullable|max:100',
        ]);
    }

    private function buildPayload(array $v, Request $r): array
    {
        $provId = FamilyService::resolveReferenceId('provinsi', (string) ($v['provinsi'] ?? ''));
        $kotaId = FamilyService::resolveReferenceId('kota_kabupaten', (string) ($v['kota'] ?? ''), 'provinsi_id', $provId);
        $kecId = FamilyService::resolveReferenceId('kecamatan', (string) ($v['kecamatan'] ?? ''), 'kota_id', $kotaId);
        $kelId = FamilyService::resolveReferenceId('kelurahan_desa', (string) ($v['kelurahan'] ?? ''), 'kecamatan_id', $kecId);

        return [
            'nik' => $v['nik'], 'nama' => trim($v['nama']), 'tempat_lahir' => trim((string) ($v['tempat_lahir'] ?? '')),
            'tanggal_lahir' => $v['tanggal_lahir'] ?? null, 'jenis_kelamin_id' => $v['jenis_kelamin_id'], 'agama_id' => $v['agama_id'],
            'status_pernikahan_id' => $v['status_pernikahan_id'] ?? null, 'hubungan_keluarga' => $v['hubungan_keluarga'],
            'pendidikan_id' => $v['pendidikan_id'] ?? null, 'pekerjaan_id' => $v['pekerjaan_id'] ?? null,
            'golongan_darah_id' => $v['golongan_darah_id'] ?? null, 'alamat' => trim((string) ($v['alamat'] ?? '')),
            'rt_rw' => trim((string) ($v['rt_rw'] ?? '')), 'kelurahan_id' => $kelId, 'kecamatan_id' => $kecId,
            'kota_id' => $kotaId, 'provinsi_id' => $provId, 'meninggal' => $r->boolean('meninggal'),
        ];
    }
}