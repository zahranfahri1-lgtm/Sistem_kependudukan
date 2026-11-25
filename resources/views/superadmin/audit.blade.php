<!DOCTYPE html><html lang="id"><head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Audit Log Aktivitas | Sistem Informasi</title>
<link rel="stylesheet" href="{{ asset('style.css') }}">
<link rel="stylesheet" href="{{ asset('redesign.css') }}">
<style>
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

th.sortable { cursor: pointer; user-select: none; }
th.sortable:hover { color: var(--purple-light); }
th.sortable::after {
  content: ' ⇅';
  font-size: 0.7rem;
  opacity: 0.4;
}
th.sortable.active::after { opacity: 1; color: var(--purple-light); }

.btn-detail {
  background: #06b6d4;
  color: #fff;
}
.btn-detail:hover { background: #0891b2; }

.audit-header-bar {
  display: flex !important;
  flex-direction: row !important;
  align-items: center !important;
  justify-content: space-between !important;
  gap: 16px;
  margin-top: 20px;
  margin-bottom: 20px;
  flex-wrap: wrap;
}
.audit-header-title h1 {
  margin: 4px 0 0;
}
.audit-header-bar .btn {
  display: inline-flex !important;
  align-items: center !important;
  justify-content: center !important;
  height: 40px;
  margin: 0 !important;
  padding: 0 18px;
  box-sizing: border-box;
  line-height: 1;
  white-space: nowrap;
}
</style>
</head><body>
@include('partials.navbar')
<div class="container">
  <div class="audit-header-bar">
    <div class="audit-header-title">
      <p class="page-eyebrow">KEAMANAN & PENGAWASAN</p>
      <h1>Audit Log Aktivitas</h1>
    </div>
    <a href="{{ route('warga.index') }}" class="btn secondary">Kembali</a>
  </div>
  <div class="table-shell">
    <table class="data-table">
      <thead>
        <tr><th>Waktu</th><th>Petugas</th><th>Aksi</th><th>Keterangan</th><th>IP</th></tr>
      </thead>
      <tbody>
        @forelse($logs as $l)
          <tr>
            <td>{{ $l->created_at }}</td>
            <td><strong>{{ $l->username }}</strong></td>
            <td>{{ $l->aksi }}</td>
            <td>{{ $l->keterangan }}</td>
            <td>{{ $l->ip_address }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="empty-state">Belum ada aktivitas tercatat.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  {{ $logs->links() }}
</div>
</body></html>