<?php
namespace App\Services;
use App\Models\Warga;
use Illuminate\Support\Facades\DB;

class FamilyService
{
    public static function relationshipOptions(): array
    {
        return ['Kepala Keluarga', 'Istri', 'Suami', 'Anak', 'Orang Tua', 'Mertua', 'Famili Lain', 'Anggota Keluarga'];
    }
    public static function currentHeadId(string $kk, ?int $ignoreId = null): ?int
    {
        if ($kk === '') return null;
        return Warga::where('hubungan_keluarga', 'Kepala Keluarga')->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))->whereHas('latestKk', fn($q) => $q->where('nomor_dokumen', $kk))->value('id');
    }
    public static function resolveReferenceId(string $tbl, string $nama, ?string $pCol = null, ?int $pId = null): ?int
    {
        if (($nama = trim($nama)) === '') return null;
        $q = DB::table($tbl)->where('nama', $nama);
        if ($pCol && $pId) $q->where($pCol, $pId);
        if ($id = $q->value('id')) return (int) $id;
        return (int) DB::table($tbl)->insertGetId(array_filter(['nama' => $nama, $pCol => $pId]));
    }
}