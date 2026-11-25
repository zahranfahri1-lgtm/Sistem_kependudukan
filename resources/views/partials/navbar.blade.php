@php
  $adminUser = Auth::guard('admin')->user();
  $isLogin = (bool) $adminUser;
@endphp
<nav class="navbar" aria-label="Navigasi utama">
  <div class="navbar-container">
    <div class="navbar-brand">
      <a href="{{ route('warga.index') }}" aria-label="Data Penduduk, halaman utama">
        <span class="navbar-brand-name">Data Penduduk</span>
      </a>
    </div>
    <div class="navbar-menu">
      <a href="{{ route('warga.index') }}" class="nav-link {{ request()->routeIs('warga.index') ? 'active' : '' }}" {!! request()->routeIs('warga.index') ? 'aria-current="page"' : '' !!}>Data Warga</a>
      <a href="{{ route('stats.index') }}" class="nav-link {{ request()->routeIs('stats.index') ? 'active' : '' }}" {!! request()->routeIs('stats.index') ? 'aria-current="page"' : '' !!}>Statistik</a>
      <a href="{{ route('populasi.index') }}" class="nav-link {{ request()->routeIs('populasi.index') ? 'active' : '' }}" {!! request()->routeIs('populasi.index') ? 'aria-current="page"' : '' !!}>Peta Indonesia</a>
      <a href="{{ route('about.index') }}" class="nav-link {{ request()->routeIs('about.index') ? 'active' : '' }}" {!! request()->routeIs('about.index') ? 'aria-current="page"' : '' !!}>Tentang</a>
      @if($isLogin)
        <a href="{{ route('warga.import') }}" class="nav-link {{ request()->routeIs('warga.import') ? 'active' : '' }}">ImportData</a>
        @if($adminUser->isSuperAdmin())
          <a href="{{ route('audit.index') }}" class="nav-link {{ request()->routeIs('audit.index') ? 'active' : '' }}">Audit Log</a>
          <a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">Kelola Admin</a>
        @endif
        <span class="command-hint">Pencarian cepat · Ctrl+K</span>
        <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display:inline;">@csrf</form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" class="nav-link btn-danger">Keluar</a>
      @else
        <a href="{{ route('login') }}" class="nav-link btn-primary {{ request()->routeIs('login') ? 'active' : '' }}">Masuk Admin</a>
      @endif
    </div>
  </div>
</nav>

@if($isLogin)
<dialog class="command-dialog" id="commandPalette" aria-labelledby="commandTitle">
  <form method="dialog" class="command-panel">
    <div class="command-heading">
      <div>
        <p class="page-eyebrow">AKSES CEPAT ADMIN</p>
        <h2 id="commandTitle">Cari atau buka halaman</h2>
      </div>
      <button type="submit" class="command-close" value="close" aria-label="Tutup pencarian">×</button>
    </div>
    <label class="sr-only" for="commandSearch">Cari nama, NIK, KK, atau halaman</label>
    <input id="commandSearch" class="command-search" type="search" placeholder="Ketik nama, NIK, KK, atau perintah..." autocomplete="off">
    <div id="commandResults" class="command-results" role="listbox" aria-label="Hasil pencarian cepat" aria-live="polite"></div>
    <p class="command-help"><kbd>↑</kbd><kbd>↓</kbd> pilih <kbd>Enter</kbd> buka <kbd>Esc</kbd> tutup</p>
  </form>
</dialog>
@endif