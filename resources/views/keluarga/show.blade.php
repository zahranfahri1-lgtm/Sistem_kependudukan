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
  <div class="page-header"><div><p class="page-eyebrow">SUSUNAN KELUARGA</p><h1>Nomor KK: {{ $nomorKk }}</h1><p class="page-subtitle">Total anggota terdaftar: {{ $members->count() }} orang</p></div><a href="{{ route('warga.index') }}" class="btn secondary">Kembali</a></div>
  <div class="table-shell"><table class="data-table"><thead><tr><th>NIK</th><th>Nama</th><th>Hubungan KK</th><th>Jenis Kelamin</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
    @foreach($members as $m)
      <tr><td>{{ Auth::guard('admin')->check() ? $m->nik : $m->masked_nik }}</td><td><strong>{{ $m->nama }}</strong></td><td>{{ $m->hubungan_keluarga }}</td><td>{{ $m->jenisKelamin?->nama ?? '-' }}</td><td>{{ $m->meninggal ? 'Meninggal' : 'Hidup' }}</td><td>@if(Auth::guard('admin')->check())<a href="{{ route('warga.show', $m) }}" class="btn detail">Detail</a>@else - @endif</td></tr>
    @endforeach
  </tbody></table></div>
</div></body></html>