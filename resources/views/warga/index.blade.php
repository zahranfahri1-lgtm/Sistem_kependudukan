<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Penduduk | Sistem Informasi</title>
<link rel="stylesheet" href="{{ asset('style.css') }}">
<style>
/* Pagination */
.pagination {
  display: flex;
  gap: 6px;
  justify-content: center;
  margin-top: 24px;
  flex-wrap: wrap;
}
.pagination a, .pagination span {
  padding: 8px 14px;
  border-radius: 10px;
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--text-dim);
  border: 1px solid var(--border);
  background: var(--card);
}
.pagination a:hover {
  background: rgba(139,92,246,0.05);
  color: var(--purple-light);
  border-color: var(--purple);
}
.pagination .active {
  background: var(--gradient);
  color: #fff;
  border-color: var(--purple);
}

/* Sort header */
th.sortable { cursor: pointer; user-select: none; }
th.sortable:hover { color: var(--purple-light); }
th.sortable::after {
  content: ' ⇅';
  font-size: 0.7rem;
  opacity: 0.4;
}
th.sortable.active::after { opacity: 1; color: var(--purple-light); }

/* Detail link in table */
.btn-detail {
  background: #06b6d4;
  color: #fff;
}
.btn-detail:hover { background: #0891b2; }
.badge-head { display: inline-flex !important; align-items: center !important; width: fit-content !important; margin: 0 !important; padding: 2px 9px !important; font-size: 0.72rem !important; font-weight: 700 !important; color: #0f766e !important; background: #ccfbf1 !important; border: 1px solid #99f6e4 !important; border-radius: 999px !important; white-space: nowrap !important; line-height: 1.2 !important; }
</style>
  <link rel="stylesheet" href="{{ asset('redesign.css') }}">
</head>
<body>
@include('partials.navbar')
@php
  $nextDir = $dir === 'ASC' ? 'DESC' : 'ASC';
  $isFiltering = collect(request()->only(['search','jenis_kelamin_id','agama_id','provinsi','rt_rw','nomor_kk','status_warga','status_pernikahan_id']))->filter()->isNotEmpty();
@endphp

<div class="content-wrap container">
  @if(session('logout_notif'))
    <div class="logout-notif"><strong>Berhasil logout</strong></div>
  @endif

  <div class="topbar page-hero">
    <div class="brand">
      <p class="page-eyebrow">PORTAL ADMINISTRASI</p>
      <h1>Data Warga</h1>
      <p>Kelola dan telusuri informasi kependudukan dalam satu tempat.</p>
    </div>
    <span class="topbar-badge"><span class="status-dot" aria-hidden="true"></span>{{ $isLogin ? ($currentAdmin->isSuperAdmin() ? 'Mode Super Admin' : 'Mode Admin Operator') : 'Informasi warga' }}</span>
  </div>

  @if(session('success'))
    <p role="status" style="margin:12px 0;padding:12px 16px;border:1px solid #86efac;border-radius:10px;background:#f0fdf4;color:#166534;font-weight:500;">{{ session('success') }}</p>
  @endif
  @if(session('error'))
    <p role="alert" style="margin:12px 0;padding:12px 16px;border:1px solid #fecaca;border-radius:10px;background:#fef2f2;color:#991b1b;font-weight:500;">{{ session('error') }}</p>
  @endif
  @if($errors->any())
    <p role="alert" style="margin:12px 0;padding:12px 16px;border:1px solid #fecaca;border-radius:10px;background:#fef2f2;color:#991b1b;font-weight:500;">{{ $errors->first() }}</p>
  @endif

  @if($isLogin)
    <form method="POST" action="{{ route('warga.store') }}" class="card form-card" id="form-tambah">
      @csrf
      <h3>Tambah Warga Baru</h3>
      <div class="grid">
        <label class="form-field"><span>NIK</span><input name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" inputmode="numeric" maxlength="16" pattern="[0-9]{16}" required></label>
        <label class="form-field"><span>Nama lengkap</span><input name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama warga" required></label>
        <label class="form-field"><span>Jenis kelamin</span>
          <select name="jenis_kelamin_id" required><option value="">Pilih jenis kelamin</option>@foreach($jenisKelamins as $r)<option value="{{ $r->id }}" @selected(old('jenis_kelamin_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
        </label>
        <label class="form-field"><span>Agama</span>
          <select name="agama_id" required><option value="">Pilih agama</option>@foreach($agamas as $r)<option value="{{ $r->id }}" @selected(old('agama_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
        </label>
        <label class="form-field"><span>Tempat lahir</span><input name="tempat_lahir" value="{{ old('tempat_lahir') }}"></label>
        <label class="form-field"><span>Tanggal lahir</span><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"></label>
        <label class="form-field"><span>Status pernikahan</span>
          <select name="status_pernikahan_id"><option value="">Pilih status</option>@foreach($statusPernikahans as $r)<option value="{{ $r->id }}" @selected(old('status_pernikahan_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
        </label>
        <label class="form-field"><span>Hubungan KK</span>
          <select name="hubungan_keluarga">@foreach($familyRoles as $role)<option value="{{ $role }}" @selected(old('hubungan_keluarga','Anggota Keluarga')===$role)>{{ $role }}</option>@endforeach</select>
        </label>
        <label class="form-field"><span>Pendidikan</span>
          <select name="pendidikan_id"><option value="">Pilih pendidikan</option>@foreach($pendidikans as $r)<option value="{{ $r->id }}" @selected(old('pendidikan_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
        </label>
        <label class="form-field"><span>Pekerjaan</span>
          <select name="pekerjaan_id"><option value="">Pilih pekerjaan</option>@foreach($pekerjaans as $r)<option value="{{ $r->id }}" @selected(old('pekerjaan_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
        </label>
        <label class="form-field"><span>Golongan darah</span>
          <select name="golongan_darah_id"><option value="">Pilih gol. darah</option>@foreach($golonganDarahs as $r)<option value="{{ $r->id }}" @selected(old('golongan_darah_id')==$r->id)>{{ $r->nama }}</option>@endforeach</select>
        </label>
        <label class="form-field"><span>Nomor KK</span><input name="nomor_kk" value="{{ old('nomor_kk') }}" maxlength="16" pattern="[0-9]{16}" placeholder="16 digit nomor KK"></label>
        <label class="form-field"><span>Alamat</span><input name="alamat" value="{{ old('alamat') }}" placeholder="Alamat lengkap"></label>
        <label class="form-field"><span>RT/RW</span><input name="rt_rw" value="{{ old('rt_rw') }}" placeholder="001/002"></label>
        <label class="form-field"><span>Kelurahan</span><input name="kelurahan" value="{{ old('kelurahan') }}"></label>
        <label class="form-field"><span>Kecamatan</span><input name="kecamatan" value="{{ old('kecamatan') }}"></label>
        <label class="form-field"><span>Kota/Kabupaten</span><input name="kota" value="{{ old('kota') }}"></label>
        <label class="form-field"><span>Provinsi</span><input name="provinsi" value="{{ old('provinsi') }}"></label>
      </div>
      <div style="margin-top:12px;display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
        <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-weight:500;"><input type="checkbox" name="meninggal" value="1" @checked(old('meninggal')) style="width:18px;height:18px;min-height:18px;padding:0;margin:0;accent-color:#115e59;cursor:pointer;"> Sudah meninggal</label>
        <button type="submit" class="btn btn-primary">Simpan Warga</button>
        <a href="{{ route('warga.index', ['export' => 1]) }}" class="btn">Export CSV</a>
        <a href="{{ route('warga.print') }}" class="btn" target="_blank">Cetak</a>
        <a href="{{ route('password.change') }}" class="btn">Ganti Password</a>
        @if($currentAdmin->isSuperAdmin())
          <a href="{{ route('backup.index') }}" class="btn">Backup DB</a>
        @endif
      </div>
    </form>
  @endif

  <form method="GET" action="{{ route('warga.index') }}" class="card filter-card">
    <div class="filter-grid">
      <label class="form-field"><span>{{ $isLogin ? 'Cari Nama / NIK' : 'Cari Nama' }}</span><input name="search" value="{{ request('search') }}" placeholder="Ketik kata pencarian"></label>
      <label class="form-field"><span>Jenis kelamin</span>
        <select name="jenis_kelamin_id"><option value="">Semua</option>@foreach($jenisKelamins as $r)<option value="{{ $r->id }}" @selected(request('jenis_kelamin_id') == $r->id)>{{ $r->nama }}</option>@endforeach</select>
      </label>
      <label class="form-field"><span>Agama</span>
        <select name="agama_id"><option value="">Semua</option>@foreach($agamas as $r)<option value="{{ $r->id }}" @selected(request('agama_id') == $r->id)>{{ $r->nama }}</option>@endforeach</select>
      </label>
      <label class="form-field"><span>Provinsi</span><input name="provinsi" value="{{ request('provinsi') }}" placeholder="Contoh: Banten"></label>
      <label class="form-field"><span>RT/RW</span><input name="rt_rw" value="{{ request('rt_rw') }}" placeholder="001/002"></label>
      <label class="form-field"><span>Nomor KK</span><input name="nomor_kk" value="{{ request('nomor_kk') }}" maxlength="16" placeholder="16 digit nomor KK"></label>
      @if($isLogin)
        <label class="form-field"><span>Status warga</span>
          <select name="status_warga"><option value="">Semua</option><option value="hidup" @selected(request('status_warga')==='hidup')>Hidup</option><option value="meninggal" @selected(request('status_warga')==='meninggal')>Meninggal</option></select>
        </label>
        <label class="form-field"><span>Status pernikahan</span>
          <select name="status_pernikahan_id"><option value="">Semua</option>@foreach($statusPernikahans as $r)<option value="{{ $r->id }}" @selected(request('status_pernikahan_id') == $r->id)>{{ $r->nama }}</option>@endforeach</select>
        </label>
      @endif
    </div>
    <div class="filter-actions">
      <button type="submit" class="btn btn-primary">Filter</button>
      @if($isFiltering)<a href="{{ route('warga.index') }}" class="btn">Reset</a>@endif
      <span>Menampilkan {{ $wargas->firstItem() ?? 0 }}–{{ $wargas->lastItem() ?? 0 }} dari {{ $wargas->total() }} warga</span>
    </div>
  </form>

  <div class="card table-section" id="daftar-warga">
    <div class="table-wrapper">
      <table>
        <thead>
          <tr>
            <th>@if($isLogin)<a href="{{ route('warga.index', array_merge(request()->query(), ['sort'=>'nik','dir'=>$nextDir])) }}">NIK</a>@else NIK @endif</th>
            <th class="sortable {{ $sort==='nama'?'active':'' }}"><a href="{{ route('warga.index', array_merge(request()->query(), ['sort'=>'nama','dir'=>$nextDir])) }}">Nama</a></th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Alamat</th>
            <th>Provinsi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($wargas as $row)
          @php $noKk = $row->latestKk?->nomor_dokumen; @endphp
          <tr>
            <td>{{ $isLogin ? $row->nik : $row->masked_nik }}</td>
            <td><div style="display:flex;flex-direction:column;align-items:flex-start;gap:4px;"><strong>{{ $row->nama }}</strong>@if($isLogin && $row->hubungan_keluarga === 'Kepala Keluarga')<span class="badge-head">Kepala Keluarga</span>@endif</div></td>
            <td>{{ $row->jenisKelamin?->nama ?? '-' }}</td>
            <td>{{ $row->agama?->nama ?? '-' }}</td>
            <td>{{ $isLogin ? ($row->alamat ?: '-') : 'Disembunyikan' }}</td>
            <td>{{ $row->provinsi?->nama ?? '-' }}</td>
            <td>
              @if($isLogin)
                <a href="{{ route('warga.show', $row) }}" class="btn btn-detail">Detail</a>
                <a href="{{ route('warga.edit', $row) }}" class="btn btn-edit">Edit</a>
                @if($noKk)<a href="{{ route('keluarga.show', $noKk) }}" class="btn">KK</a>@endif
                <form method="POST" action="{{ route('warga.toggle-meninggal', $row) }}" style="display:inline">
                  @csrf @method('PATCH')
                  <button type="submit" class="btn" style="background:{{ $row->meninggal ? '#64748b' : '#f59e0b' }};color:#fff;">
                    {{ $row->meninggal ? 'Meninggal' : 'Tandai Meninggal' }}
                  </button>
                </form>
                <form method="POST" action="{{ route('warga.destroy', $row) }}" style="display:inline" onsubmit="return confirm('Hapus {{ addslashes($row->nama) }}?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              @else
                @if($row->meninggal)
                  <span class="badge-deceased" style="color:#dc2626;font-weight:600;">Meninggal</span>
                @else
                  <span>-</span>
                @endif
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="7">Tidak ada data penduduk.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @if($wargas->hasPages())
  <div class="pagination">
    @if(!$wargas->onFirstPage())
      <a href="{{ $wargas->previousPageUrl() }}">« Prev</a>
    @endif
    @for($p = 1; $p <= $wargas->lastPage(); $p++)
      <a href="{{ $wargas->url($p) }}" class="{{ $p === $wargas->currentPage() ? 'active' : '' }}">{{ $p }}</a>
    @endfor
    @if($wargas->hasMorePages())
      <a href="{{ $wargas->nextPageUrl() }}">Next »</a>
    @endif
  </div>
  @endif
</div>

<script src="{{ asset('script.js') }}"></script>
</body>
</html>





