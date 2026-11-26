<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Admin | Data Penduduk</title>
<link rel="stylesheet" href="{{ asset('style.css') }}">
<style>
/* ===== LOGIN PAGE SPECIFIC ===== */
.login-page {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 40px 20px;
  position: relative;
  overflow: hidden;
}

/* Floating decorative blobs */
.login-blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(60px);
  z-index: 0;
  opacity: 0.35;
  animation: float 10s ease-in-out infinite;
}

.login-blob-1 {
  width: 400px;
  height: 400px;
  background: var(--purple);
  top: -100px;
  left: -100px;
  animation-delay: 0s;
}

.login-blob-2 {
  width: 300px;
  height: 300px;
  background: var(--purple-light);
  bottom: -80px;
  right: -80px;
  animation-delay: -3s;
}

.login-blob-3 {
  width: 200px;
  height: 200px;
  background: var(--accent);
  top: 40%;
  left: 50%;
  transform: translateX(-50%);
  animation-delay: -6s;
}

@keyframes float {
  0%, 100% { transform: translate(0, 0); }
  33% { transform: translate(30px, -50px); }
  66% { transform: translate(-20px, 30px); }
}

/* Subtle grid background */
.login-grid {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: 
    linear-gradient(var(--border) 1px, transparent 1px),
    linear-gradient(90deg, var(--border) 1px, transparent 1px);
  background-size: 40px 40px;
  z-index: 0;
  opacity: 0.4;
}

/* Glass card */
.login-card {
  position: relative;
  z-index: 1;
  background: rgba(13, 13, 20, 0.7);
  backdrop-filter: blur(24px);
  -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(139, 92, 246, 0.2);
  border-radius: 32px;
  padding: 48px;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 25px 60px rgba(0,0,0,0.5);
  animation: fadeInUp 0.7s ease forwards;
}

.login-header {
  text-align: center;
  margin-bottom: 32px;
}

.login-header h2 {
  font-size: 1.75rem;
  font-weight: 800;
  letter-spacing: -0.02em;
  margin-bottom: 8px;
  background: var(--gradient);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.login-header p {
  color: var(--text-dim);
  font-size: 0.95rem;
}

.login-form .form-group {
  margin-bottom: 20px;
}

.login-form label {
  display: block;
  margin-bottom: 8px;
  font-size: 0.85rem;
  font-weight: 700;
  color: var(--purple-light);
  letter-spacing: 0.05em;
  text-transform: uppercase;
}

.login-form input {
  width: 100%;
  padding: 14px 18px;
  background: #fff;
  border: 1px solid var(--border);
  border-radius: 14px;
  color: #182b31;
  font-size: 15px;
  transition: all 0.3s ease;
  font-family: inherit;
}

.login-form input:focus {
  outline: none;
  border-color: var(--purple);
  box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
  background: #fff;
}

.login-form button {
  width: 100%;
  padding: 14px;
  margin-top: 8px;
  font-size: 16px;
  font-weight: 800;
}

.login-footer {
  margin-top: 28px;
  padding-top: 20px;
  border-top: 1px solid var(--border);
  text-align: center;
  color: var(--text-dim);
  font-size: 0.85rem;
}

.login-footer a {
  color: var(--purple-light);
  text-decoration: none;
  font-weight: 700;
  transition: color 0.2s;
}

.login-footer a:hover {
  color: var(--purple);
  text-decoration: underline;
}

.error-msg {
  background: rgba(239, 68, 68, 0.1);
  border: 1px solid rgba(239, 68, 68, 0.3);
  color: #fca5a5;
  padding: 12px 16px;
  border-radius: 12px;
  margin-bottom: 24px;
  font-size: 0.85rem;
  animation: shake 0.4s ease;
}

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  25% { transform: translateX(-8px); }
  75% { transform: translateX(8px); }
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 480px) {
  .login-card { padding: 32px 24px; }
  .login-blob-1, .login-blob-2 { width: 250px; height: 250px; }
}
</style>
  <link rel="stylesheet" href="{{ asset('redesign.css') }}">
</head>
<body>
@include('partials.navbar')
<div class="login-wrap" style="max-width:440px;margin:48px auto;padding:0 16px;">
  <div class="card login-card">
    <p class="page-eyebrow">AKSES PETUGAS</p>
    <h1>Masuk Admin</h1>
    @if($errors->any())<p role="alert" style="margin-bottom:14px;padding:10px 14px;border:1px solid #ef4444;border-radius:10px;color:#fca5a5;">{{ $errors->first() }}</p>@endif
    <form method="POST" action="{{ route('login.attempt') }}">
      @csrf
      <label class="form-field" style="display:block;margin-bottom:12px;"><span>Username</span><input name="username" value="{{ old('username') }}" required autofocus></label>
      <label class="form-field" style="display:block;margin-bottom:18px;"><span>Password</span><input type="password" name="password" required></label>
      <button type="submit" class="btn btn-primary" style="width:100%;">Masuk</button>
    </form>
  </div>
</div>
<script src="{{ asset('script.js') }}"></script>
</body>
</html>