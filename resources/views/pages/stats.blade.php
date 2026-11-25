<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistik Penduduk | Data Penduduk</title>
<link rel="stylesheet" href="{{ asset('style.css') }}">
<style>
.stats-header { margin-bottom:32px; }
.chart-container { background:var(--card); border:1px solid var(--border); border-radius:20px; padding:24px; margin-bottom:24px; box-shadow:0 20px 40px rgba(0,0,0,0.3); }
.chart-title { font-size:1.1rem; font-weight:700; color:var(--text); margin-bottom:16px; display:flex; align-items:center; gap:8px; }
.chart-bars { display:grid; gap:14px; }
.chart-row { min-width:0; }
.chart-row-label { display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:6px; color:var(--text); font-size:.92rem; }
.chart-row-label span { overflow-wrap:anywhere; }
.chart-row-label strong { flex:0 0 auto; color:var(--purple-light); font-variant-numeric:tabular-nums; }
.chart-track { height:12px; overflow:hidden; border-radius:999px; background:rgba(255,255,255,.08); }
.chart-fill { display:block; height:100%; min-width:3px; border-radius:inherit; background:linear-gradient(90deg,#6d28d9,#c084fc); box-shadow:0 0 12px rgba(139,92,246,.35); transition:width .35s ease; }
.chart-row:nth-child(even) .chart-fill { background:linear-gradient(90deg,#7c3aed,#a78bfa); }
.chart-empty { color:var(--text-dim); margin:0; }
</style>
<link rel="stylesheet" href="{{ asset('redesign.css') }}">
</head>
<body>
@include('partials.navbar')
<div class="container">
  <div class="stats-header">
    <h1 style="font-size:2rem; font-weight:800; background:var(--gradient); -webkit-background-clip:text; -webkit-text-fill-color:transparent; margin-bottom:8px;">
      Statistik Penduduk
    </h1>
    <p style="color:var(--text-dim);">Visualisasi data demografi warga</p>
  </div>

  @foreach($charts as $title => $rows)
    @php $max = $rows->max('total') ?? 0; @endphp
    <div class="chart-container">
      <div class="chart-title">{{ $title }}</div>
      @if($rows->isEmpty())
        <p class="chart-empty">Belum ada data warga untuk ditampilkan.</p>
      @else
        <div class="chart-bars">
          @foreach($rows as $row)
            @php $width = $max > 0 ? max(3, ($row->total / $max) * 100) : 0; @endphp
            <div class="chart-row">
              <div class="chart-row-label"><span>{{ $row->label }}</span><strong>{{ $row->total }}</strong></div>
              <div class="chart-track"><span class="chart-fill" style="width:{{ $width }}%"></span></div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  @endforeach

  <div style="text-align:center; margin-top:24px;">
    <a href="{{ route('warga.index') }}" class="btn" style="background:var(--gradient);">← Kembali ke Data Warga</a>
  </div>
</div>
<script src="{{ asset('script.js') }}"></script>
</body>
</html>