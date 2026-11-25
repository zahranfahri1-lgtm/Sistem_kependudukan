<!DOCTYPE html><html lang="id"><head>
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
</style>
  <link rel="stylesheet" href="{{ asset('redesign.css') }}">
</head><body>
@include('partials.navbar')
<div class="container">
  <div class="page-header"><div><p class="page-eyebrow">PERBARUI DATA</p><h1>Edit: {{ $warga->nama }}</h1></div><a href="{{ route('warga.show', $warga) }}" class="btn secondary">Batal</a></div>
  @if($errors->any())<p role="alert" style="padding:12px 16px;">{{ $errors->first() }}</p>@endif
  <form method="POST" action="{{ route('warga.update', $warga) }}" class="card form-panel">
    @csrf @method('PUT')
    <div class="form-grid">
      <div class="form-field"><label>NIK</label><input name="nik" value="{{ old('nik', $warga->nik) }}" required maxlength="16"></div>
      <div class="form-field"><label>Nama</label><input name="nama" value="{{ old('nama', $warga->nama) }}" required></div>
      <div class="form-field"><label>Tempat lahir</label><input name="tempat_lahir" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}"></div>
      <div class="form-field"><label>Tanggal lahir</label><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}"></div>
      <div class="form-field"><label>Jenis kelamin</label><select name="jenis_kelamin_id">@foreach($jenisKelamins as $r)<option value="{{ $r->id }}" @selected(old('jenis_kelamin_id', $warga->jenis_kelamin_id)==$r->id)>{{ $r->nama }}</option>@endforeach</select></div>
      <div class="form-field"><label>Agama</label><select name="agama_id">@foreach($agamas as $r)<option value="{{ $r->id }}" @selected(old('agama_id', $warga->agama_id)==$r->id)>{{ $r->nama }}</option>@endforeach</select></div>
      <div class="form-field"><label>Status pernikahan</label><select name="status_pernikahan_id"><option value="">-</option>@foreach($statusPernikahans as $r)<option value="{{ $r->id }}" @selected(old('status_pernikahan_id', $warga->status_pernikahan_id)==$r->id)>{{ $r->nama }}</option>@endforeach</select></div>
      <div class="form-field"><label>Hubungan KK</label><select name="hubungan_keluarga">@foreach($familyRoles as $role)<option value="{{ $role }}" @selected(old('hubungan_keluarga', $warga->hubungan_keluarga)===$role)>{{ $role }}</option>@endforeach</select></div>
      <div class="form-field"><label>Pendidikan</label><select name="pendidikan_id"><option value="">-</option>@foreach($pendidikans as $r)<option value="{{ $r->id }}" @selected(old('pendidikan_id', $warga->pendidikan_id)==$r->id)>{{ $r->nama }}</option>@endforeach</select></div>
      <div class="form-field"><label>Pekerjaan</label><select name="pekerjaan_id"><option value="">-</option>@foreach($pekerjaans as $r)<option value="{{ $r->id }}" @selected(old('pekerjaan_id', $warga->pekerjaan_id)==$r->id)>{{ $r->nama }}</option>@endforeach</select></div>
      <div class="form-field"><label>Golongan darah</label><select name="golongan_darah_id"><option value="">-</option>@foreach($golonganDarahs as $r)<option value="{{ $r->id }}" @selected(old('golongan_darah_id', $warga->golongan_darah_id)==$r->id)>{{ $r->nama }}</option>@endforeach</select></div>
      <div class="form-field"><label>Nomor KK</label><input name="nomor_kk" value="{{ old('nomor_kk', $warga->latestKk?->nomor_dokumen) }}" maxlength="16"></div>
      <div class="form-field form-field-wide"><label>Alamat</label><input name="alamat" value="{{ old('alamat', $warga->alamat) }}"></div>
      <div class="form-field"><label>RT/RW</label><input name="rt_rw" value="{{ old('rt_rw', $warga->rt_rw) }}"></div>
      <div class="form-field"><label>Kelurahan</label><input name="kelurahan" value="{{ old('kelurahan', $warga->kelurahan?->nama) }}"></div>
      <div class="form-field"><label>Kecamatan</label><input name="kecamatan" value="{{ old('kecamatan', $warga->kecamatan?->nama) }}"></div>
      <div class="form-field"><label>Kota/Kabupaten</label><input name="kota" value="{{ old('kota', $warga->kota?->nama) }}"></div>
      <div class="form-field"><label>Provinsi</label><input name="provinsi" value="{{ old('provinsi', $warga->provinsi?->nama) }}"></div>
    </div>
    <label class="checkbox-inline" style="margin-top:12px;"><input type="checkbox" name="meninggal" value="1" @checked(old('meninggal', $warga->meninggal))><span>Tandai sudah meninggal</span></label>
    <div class="form-actions"><button type="submit" class="btn">Simpan Perubahan</button></div>
  </form>
</div></body></html>