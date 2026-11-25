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
<div class="container" style="max-width:500px;">
  <div class="page-header"><h1>Ganti Password</h1><a href="{{ route('warga.index') }}" class="btn secondary">Kembali</a></div>
  @if(session('success'))<p role="alert" style="padding:12px;">{{ session('success') }}</p>@endif
  @if($errors->any())<p role="alert" style="padding:12px;">{{ $errors->first() }}</p>@endif
  <form method="POST" action="{{ route('password.change.update') }}" class="card form-panel">
    @csrf
    <div class="form-field" style="margin-bottom:12px;"><label>Password saat ini</label><input type="password" name="current_password" required></div>
    <div class="form-field" style="margin-bottom:12px;"><label>Password baru (min. 6 karakter)</label><input type="password" name="password" required></div>
    <div class="form-field" style="margin-bottom:16px;"><label>Konfirmasi password baru</label><input type="password" name="password_confirmation" required></div>
    <button type="submit" class="btn">Perbarui Password</button>
  </form>
</div></body></html>