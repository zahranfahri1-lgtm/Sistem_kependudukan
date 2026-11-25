<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen Akun Admin & Operator | Sistem Informasi</title>
<link rel="stylesheet" href="{{ asset('style.css') }}">
<link rel="stylesheet" href="{{ asset('redesign.css') }}">
<style>
.admin-split-layout {
  display: grid;
  grid-template-columns: minmax(340px, 420px) minmax(0, 1fr);
  gap: 24px;
  align-items: start;
}
.admin-split-layout .form-panel {
  max-width: 100%;
  margin-bottom: 0;
}
.admin-split-layout .form-field {
  margin-bottom: 12px;
}
.admin-split-layout .form-field label {
  display: block;
  margin-bottom: 4px;
  font-size: 0.88rem;
}
.admin-split-layout .form-panel input,
.admin-split-layout .form-panel select {
  height: 38px !important;
  padding: 6px 12px !important;
  font-size: 0.9rem !important;
  box-sizing: border-box;
}
.admin-split-layout .table-shell {
  margin-top: 0;
  min-width: 0;
}
.form-actions-row {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-top: 18px;
}
.form-actions-row .btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  height: 42px;
  margin: 0;
  padding: 0 20px;
  box-sizing: border-box;
  line-height: 1;
}
.admin-action-group {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  flex-wrap: nowrap;
}
.admin-action-group form,
.admin-action-group button {
  margin: 0 !important;
}
@media (max-width: 1024px) {
  .admin-split-layout {
    grid-template-columns: 1fr;
  }
}
.page-header {
  margin-top: 20px;
  margin-bottom: 24px;
}
.page-header h1 {
  margin-top: 4px;
  margin-bottom: 0;
  line-height: 1.25;
}
</style>
</head>
<body>
@include('partials.navbar')

<div class="content-wrap container">
  <div class="page-header">
    <div>
      <p class="page-eyebrow">HAK AKSES SUPER ADMIN</p>
      <h1>Manajemen Akun Admin & Operator</h1>
    </div>
  </div>

  @if(session('success'))
    <p role="status" style="margin:12px 0;padding:12px 16px;border:1px solid #86efac;border-radius:10px;background:#f0fdf4;color:#166534;font-weight:500;">{{ session('success') }}</p>
  @endif
  @if($errors->any())
    <p role="alert" style="margin:12px 0;padding:12px 16px;border:1px solid #fecaca;border-radius:10px;background:#fef2f2;color:#991b1b;font-weight:500;">{{ $errors->first() }}</p>
  @endif

  <div class="admin-split-layout">
    <div class="card form-panel">
      <h2>Tambah Akun Baru</h2>
      <form method="POST" action="{{ route('admin.store') }}">
        @csrf
        <div class="form-field">
          <label>Username</label>
          <input type="text" name="username" value="{{ old('username') }}" required>
        </div>
        <div class="form-field">
          <label>Nama Lengkap</label>
          <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
        </div>
        <div class="form-field">
          <label>Password</label>
          <input type="password" name="password" required>
        </div>
        <div class="form-field">
          <label>Role Hak Akses</label>
          <select name="role">
            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin Operator</option>
            <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
          </select>
        </div>
        <div class="form-actions-row">
          <button type="submit" class="btn btn-primary">Buat Akun</button>
          <a href="{{ route('warga.index') }}" class="btn secondary">Kembali</a>
        </div>
      </form>
    </div>

    <div class="table-shell">
      <table class="data-table">
        <thead>
          <tr>
            <th>Username</th>
            <th>Nama</th>
            <th>Role</th>
            <th>Status</th>
            <th>Login Terakhir</th>
            <th>Aksi Super Admin</th>
          </tr>
        </thead>
        <tbody>
          @foreach($admins as $adm)
            <tr>
              <td><strong>{{ $adm->username }}</strong></td>
              <td>{{ $adm->nama_lengkap }}</td>
              <td>{{ $adm->role === 'super_admin' ? 'Super Admin' : 'Admin Operator' }}</td>
              <td>{{ $adm->is_active ? 'Aktif' : 'Nonaktif' }}</td>
              <td>{{ $adm->last_login_at?->diffForHumans() ?? 'Belum pernah' }}</td>
              <td>
                @if($adm->id !== Auth::guard('admin')->id())
                  <div class="admin-action-group">
                    <form method="POST" action="{{ route('admin.role', $adm) }}">
                      @csrf @method('PATCH')
                      <input type="hidden" name="role" value="{{ $adm->role === 'admin' ? 'super_admin' : 'admin' }}">
                      <button type="submit" class="btn edit">Jadikan {{ $adm->role === 'admin' ? 'Super Admin' : 'Operator' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.toggle', $adm) }}">
                      @csrf @method('PATCH')
                      <button type="submit" class="btn secondary">{{ $adm->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                    </form>
                    <form method="POST" action="{{ route('admin.destroy', $adm) }}" onsubmit="return confirm('Hapus akun {{ addslashes($adm->username) }}?')">
                      @csrf @method('DELETE')
                      <button type="submit" class="btn hapus">Hapus</button>
                    </form>
                  </div>
                @else
                  <span class="muted-text">Akun Anda saat ini</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="{{ asset('script.js') }}"></script>
</body>
</html>
