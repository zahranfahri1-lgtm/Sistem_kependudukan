<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Import Data Warga (CSV) | Sistem Informasi</title>
<link rel="stylesheet" href="{{ asset('style.css') }}">
<link rel="stylesheet" href="{{ asset('redesign.css') }}">
</head>
<body>
@include('partials.navbar')
<div class="content-wrap container">
  <div class="page-header">
    <div>
      <h1>Import Data Warga (CSV)</h1>
      <p class="page-subtitle">Format kolom CSV: NIK (16 digit), Nama Lengkap, Alamat.</p>
    </div>
  </div>

  @if(session('success'))
    <p role="status" style="margin:12px 0;padding:12px 16px;border:1px solid #86efac;border-radius:10px;background:#f0fdf4;color:#166534;font-weight:500;">{{ session('success') }}</p>
  @endif
  @if($errors->any())
    <p role="alert" style="margin:12px 0;padding:12px 16px;border:1px solid #fecaca;border-radius:10px;background:#fef2f2;color:#991b1b;font-weight:500;">{{ $errors->first() }}</p>
  @endif

  <form method="POST" action="{{ route('warga.import.store') }}" enctype="multipart/form-data" class="card form-panel">
    @csrf
    <div class="form-field">
      <label>Pilih File CSV</label>
      <input type="file" name="file" accept=".csv,.txt" required>
    </div>
    <div style="display:flex;gap:12px;align-items:center;margin-top:16px;">
      <button type="submit" class="btn btn-primary" style="display:inline-flex;align-items:center;justify-content:center;height:44px;margin:0;padding:0 20px;box-sizing:border-box;">Unggah & Impor</button>
      <a href="{{ route('warga.index') }}" class="btn secondary" style="display:inline-flex;align-items:center;justify-content:center;height:44px;margin:0;padding:0 20px;box-sizing:border-box;">Kembali</a>
    </div>
  </form>
</div>
<script src="{{ asset('script.js') }}"></script>
</body>
</html>