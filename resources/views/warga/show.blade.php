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
  <div class="page-header"><div><p class="page-eyebrow">PROFIL KEPENDUDUKAN</p><h1>{{ $warga->nama }}</h1><p class="page-subtitle">NIK: {{ $warga->nik }} • {{ $warga->hubungan_keluarga }}</p></div>
  <div class="action-bar"><a href="{{ route('warga.edit', $warga) }}" class="btn edit">Edit</a>@if($warga->latestKk)<a href="{{ route('keluarga.show', $warga->latestKk->nomor_dokumen) }}" class="btn family">Kartu Keluarga</a>@endif<a href="{{ route('warga.index') }}" class="btn secondary">Kembali</a></div></div>
  <div class="card form-panel">
    <div class="form-grid">
      <div><strong>Nomor KK:</strong><br>{{ $warga->latestKk?->nomor_dokumen ?? '-' }}</div>
      <div><strong>Tempat, Tgl Lahir:</strong><br>{{ $warga->tempat_lahir ?: '-' }}, {{ $warga->tanggal_lahir ?: '-' }}</div>
      <div><strong>Jenis Kelamin:</strong><br>{{ $warga->jenisKelamin?->nama ?? '-' }}</div>
      <div><strong>Agama:</strong><br>{{ $warga->agama?->nama ?? '-' }}</div>
      <div><strong>Status Pernikahan:</strong><br>{{ $warga->statusPernikahan?->nama ?? '-' }}</div>
      <div><strong>Pendidikan:</strong><br>{{ $warga->pendidikan?->nama ?? '-' }}</div>
      <div><strong>Pekerjaan:</strong><br>{{ $warga->pekerjaan?->nama ?? '-' }}</div>
      <div><strong>Golongan Darah:</strong><br>{{ $warga->golonganDarah?->nama ?? '-' }}</div>
      <div><strong>Status Hidup:</strong><br>{{ $warga->meninggal ? 'Meninggal' : 'Hidup' }}</div>
      <div><strong>Alamat:</strong><br>{{ $warga->alamat ?: '-' }} (RT/RW {{ $warga->rt_rw ?: '-' }})</div>
      <div><strong>Wilayah:</strong><br>{{ collect([$warga->kelurahan?->nama, $warga->kecamatan?->nama, $warga->kota?->nama, $warga->provinsi?->nama])->filter()->implode(', ') ?: '-' }}</div>
    </div>
  </div>
</div></body></html>