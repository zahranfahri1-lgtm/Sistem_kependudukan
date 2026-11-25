<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Populasi Indonesia Realtime | Data Penduduk</title>
<link rel="stylesheet" href="style.css?v=20261102-7">
<style>
/* ===== POPULASI PAGE — Wide Layout ===== */
.pop-page {
  min-height: 100vh;
  position: relative;
  overflow-x: hidden;
  padding: 32px 24px;
}

/* Grid bg */
.pop-grid {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image:
    linear-gradient(var(--border) 1px, transparent 1px),
    linear-gradient(90deg, var(--border) 1px, transparent 1px);
  background-size: 50px 50px;
  z-index: 0;
  opacity: 0.2;
}

/* Floating blobs */
.pop-blob {
  position: absolute;
  border-radius: 50%;
  filter: blur(70px);
  z-index: 0;
  opacity: 0.25;
  animation: floatPage 14s ease-in-out infinite;
}

.pop-blob-1 {
  width: 500px;
  height: 500px;
  background: var(--purple);
  top: -150px;
  left: -150px;
}

.pop-blob-2 {
  width: 400px;
  height: 400px;
  background: var(--purple-light);
  bottom: -100px;
  right: -100px;
  animation-delay: -5s;
}

.pop-blob-3 {
  width: 300px;
  height: 300px;
  background: var(--accent);
  top: 35%;
  left: 45%;
  animation-delay: -10s;
}

@keyframes floatPage {
  0%, 100% { transform: translate(0, 0) scale(1); }
  50% { transform: translate(30px, -50px) scale(1.1); }
}

/* Content container — LEBAR seperti index */
.content-wrap {
  position: relative;
  z-index: 10;
  max-width: 1100px;
  margin: 0 auto;
}

/* Topbar */
.pop-topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 15px;
  margin-bottom: 30px;
  flex-wrap: wrap;
}

/* Back button — bubble style like Login Admin */
.pop-back {
  padding: 12px 24px;
  border-radius: 16px;
  text-decoration: none;
  font-weight: 800;
  font-size: 0.95rem;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: var(--gradient);
  color: #fff;
  border: none;
  box-shadow: 0 0 0 rgba(139, 92, 246, 0);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.pop-back:hover {
  box-shadow: 0 0 30px rgba(139, 92, 246, 0.4);
  transform: translateY(-2px);
  filter: brightness(1.1);
}

/* Header */
.pop-header {
  text-align: center;
  margin-bottom: 40px;
  animation: fadeInUp 0.7s ease;
}

.pop-header h1 {
  font-size: 2.25rem;
  font-weight: 800;
  letter-spacing: -0.02em;
  margin-bottom: 10px;
  background: var(--gradient);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.pop-header p {
  color: var(--text-dim);
  font-size: 1rem;
}

/* Counter card */
.counter-card {
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 32px;
  padding: 40px;
  text-align: center;
  backdrop-filter: blur(24px);
  box-shadow: 0 25px 60px rgba(0,0,0,0.4);
  margin-bottom: 32px;
  animation: fadeInUp 0.8s ease;
  position: relative;
  overflow: hidden;
}

.counter-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background: var(--gradient);
}

.counter-card .label {
  color: var(--text-dim);
  font-size: 0.9rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  display: block;
  margin-bottom: 16px;
}

.counter-card .value {
  font-size: 3.5rem;
  font-weight: 900;
  color: var(--text);
  margin-bottom: 8px;
  font-variant-numeric: tabular-nums;
}

.counter-card .subtitle {
  color: var(--purple-light);
  font-size: 1.1rem;
  font-weight: 700;
}

/* Stat grid */
.stat-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
  gap: 16px;
  margin-bottom: 32px;
}

.stat-item {
  background: rgba(13, 13, 20, 0.5);
  border: 1px solid var(--border);
  border-radius: 20px;
  padding: 20px;
  text-align: center;
  backdrop-filter: blur(16px);
  animation: fadeInUp 0.6s ease;
}

.stat-item .stat-num {
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--purple-light);
  margin-bottom: 6px;
  font-variant-numeric: tabular-nums;
}
.stat-item:first-child .stat-num {
  font-size: clamp(.95rem, 1.4vw, 1.2rem);
  white-space: nowrap;
  letter-spacing: -.035em;
}

.stat-item .stat-lbl {
  color: var(--text-dim);
  font-size: 0.8rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

/* Table section */
.table-section {
  animation: fadeInUp 0.9s ease;
}

.table-section h3 {
  margin-bottom: 20px;
  font-size: 1.25rem;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 10px;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
  background: var(--card);
  border: 1px solid var(--border);
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.data-table th {
  background: #f2f6f5;
  color: var(--purple-light);
  font-weight: 700;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  padding: 16px 18px;
  text-align: left;
}

.data-table td {
  padding: 14px 18px;
  border-bottom: 1px solid var(--border);
  color: var(--text);
  font-size: 0.95rem;
}

.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover { background: rgba(139, 92, 246, 0.03); }

.data-table .label-col {
  font-weight: 600;
  color: var(--text-dim);
  width: 40%;
}

.data-table .value-col {
  font-variant-numeric: tabular-nums;
}

/* Source */
.source-note {
  margin-top: 32px;
  text-align: center;
  color: var(--text-dim);
  font-size: 0.8rem;
}

.source-note a {
  color: var(--purple-light);
  text-decoration: underline;
  transition: color 0.2s;
}
.source-note a:hover { color: var(--purple); }

/* Toggle button styling */
.toggle-btn-wrap {
  margin-top: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}
.indo-map {
  /* Adapted CC0 Indonesia coastline map; purple palette matches this page. */
  position: relative;
  display: block;
  flex: 0 0 auto;
  width: clamp(190px, 32vw, 300px);
  aspect-ratio: 2.5 / 1;
  overflow: visible;
  filter: drop-shadow(0 0 4px rgba(167, 116, 255, .72)) drop-shadow(0 4px 10px rgba(55, 24, 93, .75));
}
.indo-map-image { display: block; width: 100%; height: 100%; object-fit: contain; }
.island-outline {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  overflow: visible;
  pointer-events: none;
}
.island-outline path {
  fill: rgba(202, 167, 255, .13);
  stroke: #f3eaff;
  stroke-width: 2.5;
  stroke-linecap: round;
  stroke-linejoin: round;
  vector-effect: non-scaling-stroke;
  opacity: 0;
  transition: opacity .14s ease;
  filter: drop-shadow(0 0 4px #b784ff);
}
.indo-map.highlight-sumatra .outline-sumatra,
.indo-map.highlight-jawa .outline-jawa,
.indo-map.highlight-kalimantan .outline-kalimantan,
.indo-map.highlight-sulawesi .outline-sulawesi,
.indo-map.highlight-nusa .outline-nusa,
.indo-map.highlight-maluku .outline-maluku,
.indo-map.highlight-papua .outline-papua { opacity: 1; }
.island-hotspot {
  position: absolute;
  z-index: 1;
  display: block;
  padding: 0;
  border: 0;
  border-radius: 50%;
  background: transparent;
  cursor: pointer;
}
.island-hotspot::after {
  content: attr(aria-label);
  position: absolute;
  left: 50%;
  bottom: calc(100% + 7px);
  transform: translate(-50%, 4px);
  padding: 6px 9px;
  border: 1px solid rgba(183, 148, 255, .65);
  border-radius: 8px;
  background: #17121f;
  color: #eee6ff;
  font-family: inherit;
  font-size: 12px;
  font-weight: 700;
  line-height: 1.2;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: opacity .15s ease, transform .15s ease;
  filter: drop-shadow(0 4px 8px rgba(0,0,0,.45));
}
.island-hotspot:hover::after, .island-hotspot:focus-visible::after {
  opacity: 1;
  transform: translate(-50%, 0);
}
.island-hotspot:focus-visible { outline: 2px solid #e7d8ff; outline-offset: 2px; }
.hotspot-sumatra { left: 3%; top: 12%; width: 24%; height: 47%; }
.hotspot-jawa { left: 19%; top: 72%; width: 43%; height: 19%; }
.hotspot-kalimantan { left: 29%; top: 10%; width: 25%; height: 49%; }
.hotspot-sulawesi { left: 52%; top: 28%; width: 22%; height: 48%; }
.hotspot-nusa { left: 36%; top: 82%; width: 34%; height: 13%; }
.hotspot-maluku { left: 70%; top: 39%; width: 14%; height: 40%; }
.hotspot-papua { left: 82%; top: 30%; width: 18%; height: 47%; }
.island-3d-modal {
  position: fixed;
  inset: 0;
  z-index: 1000001;
  display: none;
  place-items: center;
  padding: 20px;
  background: rgba(3, 3, 9, .82);
  backdrop-filter: blur(12px);
}
.island-3d-modal.open { display: grid; animation: islandModalIn .2s ease both; }
@keyframes islandModalIn { from { opacity: 0; } to { opacity: 1; } }
.island-3d-dialog {
  width: min(820px, 96vw);
  overflow: hidden;
  border: 1px solid rgba(167,139,250,.38);
  border-radius: 24px;
  background: linear-gradient(145deg, #11101b, #080910 72%);
  box-shadow: 0 28px 90px rgba(0,0,0,.65), 0 0 42px rgba(109,40,217,.18);
}
.island-3d-head { display:flex; justify-content:space-between; align-items:center; gap:16px; padding:20px 24px 0; }
.island-3d-head h2 { color:#eee6ff; font-size:1.25rem; }
.island-3d-close { width:38px; height:38px; margin:0; padding:0; border:1px solid var(--border); background:#171523; box-shadow:none; }
.island-3d-stage {
  position:relative;
  height:min(52vh, 390px);
  min-height:270px;
  margin:6px 18px 0;
  overflow:hidden;
  border-radius:18px;
  background:radial-gradient(ellipse at 50% 44%, rgba(89,56,150,.18), transparent 62%);
  perspective:900px;
  touch-action:none;
  cursor:grab;
}
.island-3d-stage.dragging { cursor:grabbing; }
.island-3d-object {
  position:absolute;
  left:50%; top:50%;
  width:min(600px, 82vw);
  height:min(340px, 44vw);
  min-height:230px;
  transform:translate(-50%,-50%) rotateX(54deg) rotateY(-18deg);
  transform-style:preserve-3d;
  transition:transform .12s ease-out;
}
.island-3d-stage.dragging .island-3d-object { transition:none; }
.ocean-depth-plate {
  position:absolute;
  left:50%; top:50%;
  width:84%; height:78%;
  border:1px solid rgba(138,111,219,.55);
  border-radius:50%;
  background:radial-gradient(ellipse at 48% 38%, #30205a 0%, #211a45 29%, #111b37 57%, #080d1c 82%, #05070e 100%);
  box-shadow:0 0 0 5px rgba(82,54,142,.2), 0 18px 30px rgba(0,0,0,.6);
  transform:translate(-50%,-50%) translateZ(-78px);
  transform-style:preserve-3d;
}
.ocean-depth-lines { position:absolute; inset:5%; width:90%; height:90%; overflow:visible; }
.ocean-depth-lines ellipse { fill:none; stroke:rgba(183,148,255,.36); stroke-width:1.2; vector-effect:non-scaling-stroke; }
.ocean-depth-lines text { fill:rgba(225,212,255,.72); font:700 10px/1 sans-serif; letter-spacing:.04em; }
.island-model-stack { position:absolute; left:50%; top:50%; transform:translate(-50%,-50%); transform-style:preserve-3d; }
.island-model-layer { position:absolute; inset:0; width:100%; height:100%; overflow:visible; backface-visibility:visible; }
.island-model-layer path { stroke:rgba(223,208,255,.3); stroke-width:1.2; vector-effect:non-scaling-stroke; }
.island-model-top path { fill:url(#islandLandGradient); stroke:#e6d8ff; stroke-width:2; }
.island-underbelly path { stroke:rgba(211,184,244,.2); stroke-width:1.1; vector-effect:non-scaling-stroke; }
.mountain-relief { position:absolute; inset:0; width:100%; height:100%; overflow:visible; transform:translateZ(19px); transform-style:preserve-3d; pointer-events:none; filter:drop-shadow(5px 9px 5px rgba(20,12,32,.55)); }
.mountain-relief .mountain-base { fill:#9a79c5; stroke:rgba(240,230,255,.7); stroke-width:1.1; }
.mountain-relief .mountain-light { fill:#dfcdf5; }
.mountain-relief .mountain-mid { fill:#aa8bcf; }
.mountain-relief .mountain-shadow { fill:#594175; }
.mountain-relief .mountain-dark { fill:#392a49; }
.mountain-relief .mountain-ridge { fill:none; stroke:rgba(255,255,255,.65); stroke-width:1.3; }
.mountain-relief polygon { stroke:rgba(234,220,255,.22); stroke-width:.55; vector-effect:non-scaling-stroke; }
.dem-terrain-layer { pointer-events:none; filter:drop-shadow(2px 3px 2px rgba(20,12,32,.58)); }
.dem-terrain-layer polygon { stroke:rgba(32,20,48,.18); stroke-width:.45; vector-effect:non-scaling-stroke; }
.lowpoly-tree .tree-trunk { fill:#4d365b; stroke:rgba(24,14,35,.65); stroke-width:1; }
.lowpoly-tree .tree-light { fill:#d7b6ff; stroke:rgba(242,227,255,.45); stroke-width:.7; }
.lowpoly-tree .tree-mid { fill:#a77bd2; stroke:rgba(42,27,59,.45); stroke-width:.7; }
.lowpoly-tree .tree-shadow { fill:#67488c; stroke:rgba(33,20,48,.55); stroke-width:.7; }
.island-3d-caption { display:flex; justify-content:center; align-items:center; gap:14px; flex-wrap:wrap; padding:4px 22px 18px; color:var(--text-dim); font-size:.82rem; text-align:center; }
.island-3d-caption strong { color:#c4a7ff; }
.island-3d-reset { margin:0; padding:8px 13px; border:1px solid rgba(167,139,250,.35); background:#171523; box-shadow:none; font-size:.8rem; }
@media (max-width:640px) {
  .island-3d-modal { padding:10px; }
  .island-3d-head { padding:16px 16px 0; }
  .island-3d-stage { margin:6px 8px 0; min-height:240px; }
  .island-3d-object { width:88vw; height:260px; }
  .island-3d-caption { padding:4px 12px 14px; }
}
.counter-display {
  position: relative;
  min-height: 112px;
  padding: 0 150px;
}
.counter-display .value {
  flex: 1 0 100%;
  width: 100%;
  text-align: center;
}
.counter-display .indo-map {
  position: absolute;
  right: 0;
  top: 50%;
  width: 180px;
  transform: translateY(-50%);
}

#btnToggleKota {
  background: var(--gradient);
  color: #fff;
  border: none;
  padding: 12px 28px;
  border-radius: 14px;
  font-weight: 800;
  font-size: 0.95rem;
  cursor: pointer;
  box-shadow: 0 10px 25px rgba(139, 92, 246, 0.3);
  transition: all 0.3s;
}
#btnToggleKota:hover {
  box-shadow: 0 0 30px rgba(139, 92, 246, 0.4);
  transform: translateY(-2px);
  filter: brightness(1.1);
}

@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(25px); }
  to { opacity: 1; transform: translateY(0); }
}

@media (max-width: 640px) {
  .counter-card .value { font-size: 2.5rem; }
  .counter-display { min-height: 96px; padding: 0 82px 0 0; }
  .counter-display .value { font-size: clamp(1.65rem, 8vw, 2.5rem); }
  .counter-display .indo-map { width: min(132px, 34vw); }
  .toggle-btn-wrap .indo-map { width: min(240px, 70vw); }
  .stat-grid { grid-template-columns: 1fr 1fr; }
  .pop-topbar { flex-direction: column; align-items: stretch; }
}
</style>
  <link rel="stylesheet" href="redesign.css?v=20261107-13">
</head>
<body>
@include('partials.navbar')

<div class="pop-page">
  <div class="pop-grid"></div>
  <div class="pop-blob pop-blob-1"></div>
  <div class="pop-blob pop-blob-2"></div>
  <div class="pop-blob pop-blob-3"></div>

  <div class="content-wrap container">
    <div class="pop-topbar">
      <a href="index.php" class="pop-back">← Kembali ke Data Penduduk</a>
    </div>

    <div class="pop-header">
      <h1> Populasi Indonesia</h1>
      <p>Data realtime dari <strong>Worldometers.info</strong> dan Perserikatan Bangsa-Bangsa (UN)</p>
    </div>

    <!-- Counter -->
    <div class="counter-card">
      <span class="label">Populasi Indonesia Saat Ini</span>
      <div class="counter-display" style="display:flex; align-items:center; justify-content:center; gap:20px;">
        <div class="value" id="liveCounter">286.986.308</div>
        <div class="indo-map" role="group" aria-label="Peta Indonesia. Arahkan kursor untuk melihat nama, klik pulau untuk model 3D.">
          <img class="indo-map-image" src="indonesia-map.svg" alt="">
          <svg class="island-outline" viewBox="0 0 1000 400" aria-hidden="true">
            <path class="outline-sumatra" d="M80 45 Q99 48 116 67 L145 88 Q172 105 188 128 L219 153 Q244 172 258 190 Q253 208 235 209 Q216 202 199 181 L174 157 Q151 141 132 123 L105 99 Q88 80 76 63 Q70 53 80 45Z"/>
            <path class="outline-jawa" d="M195 285 Q235 287 281 294 L367 303 452 311 532 318 Q590 322 622 331 L616 340 Q578 341 531 335 L448 328 365 319 285 309 218 301 Q193 297 195 285Z"/>
            <path class="outline-kalimantan" d="M329 82 Q357 53 395 57 L423 42 461 54 489 81 510 113 499 146 480 171 466 205 442 230 414 237 393 218 366 207 346 183 329 157 315 128 319 102Z"/>
            <path class="outline-sulawesi" d="M535 117 Q548 92 565 97 L579 125 594 144 614 111 632 99 644 109 633 143 615 166 635 180 663 168 688 175 682 192 650 205 624 220 613 248 596 272 581 264 586 232 574 210 551 225 533 216 550 189 568 174 550 158Z"/>
            <path class="outline-nusa" d="M376 354 Q411 350 450 358 L492 365 533 366 574 373 612 374 648 382 630 389 586 384 543 379 500 376 457 369 414 365 382 362Z"/>
            <path class="outline-maluku" d="M700 181 Q711 167 721 180 L726 198 718 210 706 204Z M742 216 Q754 201 765 214 L769 232 758 242 746 234Z M779 178 Q790 167 799 180 L795 199 783 203Z M717 260 Q727 250 738 261 L736 275 723 279Z"/>
            <path class="outline-papua" d="M828 166 Q851 150 879 158 L905 151 931 164 955 170 981 189 988 213 975 232 950 237 927 251 903 261 878 278 852 277 835 260 823 237 814 215 819 189Z"/>
          </svg>
          <button class="island-hotspot hotspot-sumatra" type="button" data-island="sumatra" aria-label="Pulau Sumatra"></button>
          <button class="island-hotspot hotspot-jawa" type="button" data-island="jawa" aria-label="Pulau Jawa"></button>
          <button class="island-hotspot hotspot-kalimantan" type="button" data-island="kalimantan" aria-label="Pulau Kalimantan"></button>
          <button class="island-hotspot hotspot-sulawesi" type="button" data-island="sulawesi" aria-label="Pulau Sulawesi"></button>
          <button class="island-hotspot hotspot-nusa" type="button" data-island="nusa" aria-label="Bali dan Nusa Tenggara"></button>
          <button class="island-hotspot hotspot-maluku" type="button" data-island="maluku" aria-label="Kepulauan Maluku"></button>
          <button class="island-hotspot hotspot-papua" type="button" data-island="papua" aria-label="Pulau Papua"></button>
        </div>
      </div>
      <div class="subtitle">per Senin, 26 Januari 2026</div>
    </div>

    <!-- Stats -->
    <div class="stat-grid">
      <div class="stat-item">
        <div class="stat-num">287.886.782</div>
        <div class="stat-lbl">Proyeksi 2026</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">#4</div>
        <div class="stat-lbl">Peringkat Dunia</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">159</div>
        <div class="stat-lbl">Kepadatan /km²</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">30,7</div>
        <div class="stat-lbl">Usia Median</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">60,27%</div>
        <div class="stat-lbl">Populasi Perkotaan</div>
      </div>
      <div class="stat-item">
        <div class="stat-num">3,47%</div>
        <div class="stat-lbl">Pangsa Dunia</div>
      </div>
    </div>

    <!-- Table -->
    <div class="card table-section">
      <h3> Kota Utama Berdasarkan Populasi di Indonesia (2025)</h3>
      <table class="data-table">
        <thead>
          <tr>
            <th style="width:8%;">Peringkat</th>
            <th>Kawasan Perkotaan</th>
            <th style="width:25%; text-align:right;">Estimasi Populasi (2025)</th>
          </tr>
        </thead>
        <tbody id="kotaBody">
          <!-- Top 10 selalu ditampilkan -->
          <tr><td>1</td><td>Jakarta</td><td style="text-align:right;">41.913.860</td></tr>
          <tr><td>2</td><td>Bandung</td><td style="text-align:right;">8.909.104</td></tr>
          <tr><td>3</td><td>Surabaya</td><td style="text-align:right;">6.843.503</td></tr>
          <tr><td>4</td><td>Medan</td><td style="text-align:right;">4.245.895</td></tr>
          <tr><td>5</td><td>Tasikmalaya</td><td style="text-align:right;">2.827.255</td></tr>
          <tr><td>6</td><td>Yogyakarta</td><td style="text-align:right;">2.793.747</td></tr>
          <tr><td>7</td><td>Semarang</td><td style="text-align:right;">2.679.349</td></tr>
          <tr><td>8</td><td>Denpasar</td><td style="text-align:right;">2.352.734</td></tr>
          <tr><td>9</td><td>Makassar</td><td style="text-align:right;">2.255.088</td></tr>
          <tr><td>10</td><td>Palembang</td><td style="text-align:right;">2.132.576</td></tr>
          
          <!-- Admin: tampilkan semua 70 kota langsung -->
          <tr><td>11</td><td>Tarogong</td><td style="text-align:right;">1.917.036</td></tr>
          <tr><td>12</td><td>Malang</td><td style="text-align:right;">1.899.616</td></tr>
          <tr><td>13</td><td>Slawi</td><td style="text-align:right;">1.733.937</td></tr>
          <tr><td>14</td><td>Cirebon</td><td style="text-align:right;">1.566.821</td></tr>
          <tr><td>15</td><td>Surakarta</td><td style="text-align:right;">1.538.599</td></tr>
          <tr><td>16</td><td>Batam City</td><td style="text-align:right;">1.500.354</td></tr>
          <tr><td>17</td><td>Purwokerto</td><td style="text-align:right;">1.331.010</td></tr>
          <tr><td>18</td><td>Samarinda</td><td style="text-align:right;">1.325.554</td></tr>
          <tr><td>19</td><td>Pekanbaru</td><td style="text-align:right;">1.208.872</td></tr>
          <tr><td>20</td><td>Padang</td><td style="text-align:right;">1.184.342</td></tr>
          <tr><td>21</td><td>Bandar Lampung</td><td style="text-align:right;">1.184.054</td></tr>
          <tr><td>22</td><td>Mataram</td><td style="text-align:right;">997.132</td></tr>
          <tr><td>23</td><td>Jambi</td><td style="text-align:right;">980.534</td></tr>
          <tr><td>24</td><td>Pekalongan</td><td style="text-align:right;">978.519</td></tr>
          <tr><td>25</td><td>Banjarmasin</td><td style="text-align:right;">930.711</td></tr>
          <tr><td>26</td><td>Pontianak</td><td style="text-align:right;">808.759</td></tr>
          <tr><td>27</td><td>Tulungagung</td><td style="text-align:right;">728.924</td></tr>
          <tr><td>28</td><td>Balikpapan</td><td style="text-align:right;">728.771</td></tr>
          <tr><td>29</td><td>Jepara</td><td style="text-align:right;">714.514</td></tr>
          <tr><td>30</td><td>Kudus</td><td style="text-align:right;">671.940</td></tr>
          <tr><td>31</td><td>Magelang</td><td style="text-align:right;">640.707</td></tr>
          <tr><td>32</td><td>Kuningan</td><td style="text-align:right;">636.447</td></tr>
          <tr><td>33</td><td>Cipanas</td><td style="text-align:right;">610.177</td></tr>
          <tr><td>34</td><td>Selong</td><td style="text-align:right;">568.139</td></tr>
          <tr><td>35</td><td>Ambon</td><td style="text-align:right;">555.651</td></tr>
          <tr><td>36</td><td>Purwakarta</td><td style="text-align:right;">549.480</td></tr>
          <tr><td>37</td><td>Cilacap</td><td style="text-align:right;">544.657</td></tr>
          <tr><td>38</td><td>Kendal</td><td style="text-align:right;">541.030</td></tr>
          <tr><td>39</td><td>Kupang</td><td style="text-align:right;">538.998</td></tr>
          <tr><td>40</td><td>Jember</td><td style="text-align:right;">522.844</td></tr>
          <tr><td>41</td><td>Gorontalo</td><td style="text-align:right;">513.078</td></tr>
          <tr><td>42</td><td>Balung</td><td style="text-align:right;">497.754</td></tr>
          <tr><td>43</td><td>Kediri</td><td style="text-align:right;">480.038</td></tr>
          <tr><td>44</td><td>Jombang</td><td style="text-align:right;">478.051</td></tr>
          <tr><td>45</td><td>Manado</td><td style="text-align:right;">464.793</td></tr>
          <tr><td>46</td><td>Pematang Siantar</td><td style="text-align:right;">446.269</td></tr>
          <tr><td>47</td><td>Blitar</td><td style="text-align:right;">442.219</td></tr>
          <tr><td>48</td><td>Gresik</td><td style="text-align:right;">426.246</td></tr>
          <tr><td>49</td><td>Probolinggo</td><td style="text-align:right;">420.356</td></tr>
          <tr><td>50</td><td>Nganjuk</td><td style="text-align:right;">409.447</td></tr>
          <tr><td>51</td><td>Kendari</td><td style="text-align:right;">408.731</td></tr>
          <tr><td>52</td><td>Madiun</td><td style="text-align:right;">397.871</td></tr>
          <tr><td>53</td><td>Rangkasbitung</td><td style="text-align:right;">389.934</td></tr>
          <tr><td>54</td><td>Bengkulu</td><td style="text-align:right;">378.066</td></tr>
          <tr><td>55</td><td>Timika</td><td style="text-align:right;">375.910</td></tr>
          <tr><td>56</td><td>Palu</td><td style="text-align:right;">348.948</td></tr>
          <tr><td>57</td><td>Banda Aceh</td><td style="text-align:right;">343.382</td></tr>
          <tr><td>58</td><td>Duri</td><td style="text-align:right;">335.728</td></tr>
          <tr><td>59</td><td>Indramayu</td><td style="text-align:right;">335.572</td></tr>
          <tr><td>60</td><td>Sumedang</td><td style="text-align:right;">324.936</td></tr>
          <tr><td>61</td><td>Pandeglang</td><td style="text-align:right;">324.139</td></tr>
          <tr><td>62</td><td>Bodeh</td><td style="text-align:right;">323.511</td></tr>
          <tr><td>63</td><td>Dumai</td><td style="text-align:right;">317.280</td></tr>
          <tr><td>64</td><td>Kebumen</td><td style="text-align:right;">312.542</td></tr>
          <tr><td>65</td><td>Singaraja</td><td style="text-align:right;">300.490</td></tr>
          <tr><td>66</td><td>Bukittinggi</td><td style="text-align:right;">299.353</td></tr>
          <tr><td>67</td><td>Sorong</td><td style="text-align:right;">299.181</td></tr>
          <tr><td>68</td><td>Bojonegoro</td><td style="text-align:right;">298.285</td></tr>
          <tr><td>69</td><td>Wonosobo</td><td style="text-align:right;">295.758</td></tr>
          <tr><td>70</td><td>Pangkalpinang</td><td style="text-align:right;">291.683</td></tr>
          
          <!-- User biasa: tampilkan tombol toggle untuk 11-70 -->
          <tr class="kota-extra" style="display:none;"><td>11</td><td>Tarogong</td><td style="text-align:right;">1.917.036</td></tr>
          <tr class="kota-extra" style="display:none;"><td>12</td><td>Malang</td><td style="text-align:right;">1.899.616</td></tr>
          <tr class="kota-extra" style="display:none;"><td>13</td><td>Slawi</td><td style="text-align:right;">1.733.937</td></tr>
          <tr class="kota-extra" style="display:none;"><td>14</td><td>Cirebon</td><td style="text-align:right;">1.566.821</td></tr>
          <tr class="kota-extra" style="display:none;"><td>15</td><td>Surakarta</td><td style="text-align:right;">1.538.599</td></tr>
          <tr class="kota-extra" style="display:none;"><td>16</td><td>Batam City</td><td style="text-align:right;">1.500.354</td></tr>
          <tr class="kota-extra" style="display:none;"><td>17</td><td>Purwokerto</td><td style="text-align:right;">1.331.010</td></tr>
          <tr class="kota-extra" style="display:none;"><td>18</td><td>Samarinda</td><td style="text-align:right;">1.325.554</td></tr>
          <tr class="kota-extra" style="display:none;"><td>19</td><td>Pekanbaru</td><td style="text-align:right;">1.208.872</td></tr>
          <tr class="kota-extra" style="display:none;"><td>20</td><td>Padang</td><td style="text-align:right;">1.184.342</td></tr>
          <tr class="kota-extra" style="display:none;"><td>21</td><td>Bandar Lampung</td><td style="text-align:right;">1.184.054</td></tr>
          <tr class="kota-extra" style="display:none;"><td>22</td><td>Mataram</td><td style="text-align:right;">997.132</td></tr>
          <tr class="kota-extra" style="display:none;"><td>23</td><td>Jambi</td><td style="text-align:right;">980.534</td></tr>
          <tr class="kota-extra" style="display:none;"><td>24</td><td>Pekalongan</td><td style="text-align:right;">978.519</td></tr>
          <tr class="kota-extra" style="display:none;"><td>25</td><td>Banjarmasin</td><td style="text-align:right;">930.711</td></tr>
          <tr class="kota-extra" style="display:none;"><td>26</td><td>Pontianak</td><td style="text-align:right;">808.759</td></tr>
          <tr class="kota-extra" style="display:none;"><td>27</td><td>Tulungagung</td><td style="text-align:right;">728.924</td></tr>
          <tr class="kota-extra" style="display:none;"><td>28</td><td>Balikpapan</td><td style="text-align:right;">728.771</td></tr>
          <tr class="kota-extra" style="display:none;"><td>29</td><td>Jepara</td><td style="text-align:right;">714.514</td></tr>
          <tr class="kota-extra" style="display:none;"><td>30</td><td>Kudus</td><td style="text-align:right;">671.940</td></tr>
          <tr class="kota-extra" style="display:none;"><td>31</td><td>Magelang</td><td style="text-align:right;">640.707</td></tr>
          <tr class="kota-extra" style="display:none;"><td>32</td><td>Kuningan</td><td style="text-align:right;">636.447</td></tr>
          <tr class="kota-extra" style="display:none;"><td>33</td><td>Cipanas</td><td style="text-align:right;">610.177</td></tr>
          <tr class="kota-extra" style="display:none;"><td>34</td><td>Selong</td><td style="text-align:right;">568.139</td></tr>
          <tr class="kota-extra" style="display:none;"><td>35</td><td>Ambon</td><td style="text-align:right;">555.651</td></tr>
          <tr class="kota-extra" style="display:none;"><td>36</td><td>Purwakarta</td><td style="text-align:right;">549.480</td></tr>
          <tr class="kota-extra" style="display:none;"><td>37</td><td>Cilacap</td><td style="text-align:right;">544.657</td></tr>
          <tr class="kota-extra" style="display:none;"><td>38</td><td>Kendal</td><td style="text-align:right;">541.030</td></tr>
          <tr class="kota-extra" style="display:none;"><td>39</td><td>Kupang</td><td style="text-align:right;">538.998</td></tr>
          <tr class="kota-extra" style="display:none;"><td>40</td><td>Jember</td><td style="text-align:right;">522.844</td></tr>
          <tr class="kota-extra" style="display:none;"><td>41</td><td>Gorontalo</td><td style="text-align:right;">513.078</td></tr>
          <tr class="kota-extra" style="display:none;"><td>42</td><td>Balung</td><td style="text-align:right;">497.754</td></tr>
          <tr class="kota-extra" style="display:none;"><td>43</td><td>Kediri</td><td style="text-align:right;">480.038</td></tr>
          <tr class="kota-extra" style="display:none;"><td>44</td><td>Jombang</td><td style="text-align:right;">478.051</td></tr>
          <tr class="kota-extra" style="display:none;"><td>45</td><td>Manado</td><td style="text-align:right;">464.793</td></tr>
          <tr class="kota-extra" style="display:none;"><td>46</td><td>Pematang Siantar</td><td style="text-align:right;">446.269</td></tr>
          <tr class="kota-extra" style="display:none;"><td>47</td><td>Blitar</td><td style="text-align:right;">442.219</td></tr>
          <tr class="kota-extra" style="display:none;"><td>48</td><td>Gresik</td><td style="text-align:right;">426.246</td></tr>
          <tr class="kota-extra" style="display:none;"><td>49</td><td>Probolinggo</td><td style="text-align:right;">420.356</td></tr>
          <tr class="kota-extra" style="display:none;"><td>50</td><td>Nganjuk</td><td style="text-align:right;">409.447</td></tr>
          <tr class="kota-extra" style="display:none;"><td>51</td><td>Kendari</td><td style="text-align:right;">408.731</td></tr>
          <tr class="kota-extra" style="display:none;"><td>52</td><td>Madiun</td><td style="text-align:right;">397.871</td></tr>
          <tr class="kota-extra" style="display:none;"><td>53</td><td>Rangkasbitung</td><td style="text-align:right;">389.934</td></tr>
          <tr class="kota-extra" style="display:none;"><td>54</td><td>Bengkulu</td><td style="text-align:right;">378.066</td></tr>
          <tr class="kota-extra" style="display:none;"><td>55</td><td>Timika</td><td style="text-align:right;">375.910</td></tr>
          <tr class="kota-extra" style="display:none;"><td>56</td><td>Palu</td><td style="text-align:right;">348.948</td></tr>
          <tr class="kota-extra" style="display:none;"><td>57</td><td>Banda Aceh</td><td style="text-align:right;">343.382</td></tr>
          <tr class="kota-extra" style="display:none;"><td>58</td><td>Duri</td><td style="text-align:right;">335.728</td></tr>
          <tr class="kota-extra" style="display:none;"><td>59</td><td>Indramayu</td><td style="text-align:right;">335.572</td></tr>
          <tr class="kota-extra" style="display:none;"><td>60</td><td>Sumedang</td><td style="text-align:right;">324.936</td></tr>
          <tr class="kota-extra" style="display:none;"><td>61</td><td>Pandeglang</td><td style="text-align:right;">324.139</td></tr>
          <tr class="kota-extra" style="display:none;"><td>62</td><td>Bodeh</td><td style="text-align:right;">323.511</td></tr>
          <tr class="kota-extra" style="display:none;"><td>63</td><td>Dumai</td><td style="text-align:right;">317.280</td></tr>
          <tr class="kota-extra" style="display:none;"><td>64</td><td>Kebumen</td><td style="text-align:right;">312.542</td></tr>
          <tr class="kota-extra" style="display:none;"><td>65</td><td>Singaraja</td><td style="text-align:right;">300.490</td></tr>
          <tr class="kota-extra" style="display:none;"><td>66</td><td>Bukittinggi</td><td style="text-align:right;">299.353</td></tr>
          <tr class="kota-extra" style="display:none;"><td>67</td><td>Sorong</td><td style="text-align:right;">299.181</td></tr>
          <tr class="kota-extra" style="display:none;"><td>68</td><td>Bojonegoro</td><td style="text-align:right;">298.285</td></tr>
          <tr class="kota-extra" style="display:none;"><td>69</td><td>Wonosobo</td><td style="text-align:right;">295.758</td></tr>
          <tr class="kota-extra" style="display:none;"><td>70</td><td>Pangkalpinang</td><td style="text-align:right;">291.683</td></tr>
          
        </tbody>
      </table>

      <!-- Toggle button + Peta Indonesia (hanya untuk user biasa) -->
      
      <div class="toggle-btn-wrap">
        <div class="indo-map" role="group" aria-label="Peta Indonesia. Arahkan kursor untuk melihat nama, klik pulau untuk model 3D.">
          <img class="indo-map-image" src="indonesia-map.svg" alt="">
          <svg class="island-outline" viewBox="0 0 1000 400" aria-hidden="true">
            <path class="outline-sumatra" d="M80 45 Q99 48 116 67 L145 88 Q172 105 188 128 L219 153 Q244 172 258 190 Q253 208 235 209 Q216 202 199 181 L174 157 Q151 141 132 123 L105 99 Q88 80 76 63 Q70 53 80 45Z"/>
            <path class="outline-jawa" d="M195 285 Q235 287 281 294 L367 303 452 311 532 318 Q590 322 622 331 L616 340 Q578 341 531 335 L448 328 365 319 285 309 218 301 Q193 297 195 285Z"/>
            <path class="outline-kalimantan" d="M329 82 Q357 53 395 57 L423 42 461 54 489 81 510 113 499 146 480 171 466 205 442 230 414 237 393 218 366 207 346 183 329 157 315 128 319 102Z"/>
            <path class="outline-sulawesi" d="M535 117 Q548 92 565 97 L579 125 594 144 614 111 632 99 644 109 633 143 615 166 635 180 663 168 688 175 682 192 650 205 624 220 613 248 596 272 581 264 586 232 574 210 551 225 533 216 550 189 568 174 550 158Z"/>
            <path class="outline-nusa" d="M376 354 Q411 350 450 358 L492 365 533 366 574 373 612 374 648 382 630 389 586 384 543 379 500 376 457 369 414 365 382 362Z"/>
            <path class="outline-maluku" d="M700 181 Q711 167 721 180 L726 198 718 210 706 204Z M742 216 Q754 201 765 214 L769 232 758 242 746 234Z M779 178 Q790 167 799 180 L795 199 783 203Z M717 260 Q727 250 738 261 L736 275 723 279Z"/>
            <path class="outline-papua" d="M828 166 Q851 150 879 158 L905 151 931 164 955 170 981 189 988 213 975 232 950 237 927 251 903 261 878 278 852 277 835 260 823 237 814 215 819 189Z"/>
          </svg>
          <button class="island-hotspot hotspot-sumatra" type="button" data-island="sumatra" aria-label="Pulau Sumatra"></button>
          <button class="island-hotspot hotspot-jawa" type="button" data-island="jawa" aria-label="Pulau Jawa"></button>
          <button class="island-hotspot hotspot-kalimantan" type="button" data-island="kalimantan" aria-label="Pulau Kalimantan"></button>
          <button class="island-hotspot hotspot-sulawesi" type="button" data-island="sulawesi" aria-label="Pulau Sulawesi"></button>
          <button class="island-hotspot hotspot-nusa" type="button" data-island="nusa" aria-label="Bali dan Nusa Tenggara"></button>
          <button class="island-hotspot hotspot-maluku" type="button" data-island="maluku" aria-label="Kepulauan Maluku"></button>
          <button class="island-hotspot hotspot-papua" type="button" data-island="papua" aria-label="Pulau Papua"></button>
        </div>
        <button id="btnToggleKota"> Lihat selengkapnya (70 kota)</button>
      </div>
      
    </div>

    <div class="source-note">
      Sumber: <a href="https://www.worldometers.info/id/populasi-dunia/populasi-indonesia/" target="_blank">Worldometers.info</a> — Elaborasi data oleh Perserikatan Bangsa-Bangsa, UN DESA, Divisi Kependudukan. Revisi 2024.
    </div>
  </div>
</div>

<div class="island-3d-modal" id="island3DModal" aria-hidden="true">
  <section class="island-3d-dialog" role="dialog" aria-modal="true" aria-labelledby="island3DTitle">
    <div class="island-3d-head">
      <h2 id="island3DTitle">Model Pulau 3D</h2>
      <button class="island-3d-close" id="closeIsland3D" type="button" aria-label="Tutup">×</button>
    </div>
    <div class="island-3d-stage" id="island3DStage" tabindex="0" aria-label="Seret untuk memutar model pulau">
      <div class="island-3d-object" id="island3DObject">
        <div class="ocean-depth-plate" aria-hidden="true">
          <svg class="ocean-depth-lines" viewBox="0 0 600 360" aria-hidden="true">
            <g class="bathymetry-generated"></g>
          </svg>
        </div>
        <div class="island-model-stack" id="islandModelStack"></div>
      </div>
    </div>
    <div class="island-3d-caption">
      <span>Seret untuk memutar • relief darat dan kontur kedalaman <strong>ETOPO 2022 NOAA</strong></span>
      <button class="island-3d-reset" id="resetIsland3D" type="button">↺ Atur ulang</button>
    </div>
  </section>
</div>

<script>
(function() {
  var modal = document.getElementById('island3DModal');
  var stage = document.getElementById('island3DStage');
  var object = document.getElementById('island3DObject');
  var stack = document.getElementById('islandModelStack');
  var title = document.getElementById('island3DTitle');
  var closeButton = document.getElementById('closeIsland3D');
  var resetButton = document.getElementById('resetIsland3D');
  var returnFocus = null;
  var rotationX = 60, rotationY = -18, dragging = false, startX = 0, startY = 0, startRotationX = 0, startRotationY = 0;
  var modelRevision = 0;
  var svgNS = 'http://www.w3.org/2000/svg';

  function applyRotation() {
    object.style.transform = 'translate(-50%,-50%) rotateX(' + rotationX + 'deg) rotateY(' + rotationY + 'deg)';
  }

  function makeSvg(tag, attrs) {
    var el = document.createElementNS(svgNS, tag);
    Object.keys(attrs || {}).forEach(function(key) { el.setAttribute(key, attrs[key]); });
    return el;
  }

  var demGridCache = new Map();
  var islandRegions = {
    sumatra: [94.5, 106.5, -6.5, 6.5],
    jawa: [104.5, 115, -9.5, -5.2],
    kalimantan: [108, 119.5, -4.5, 4.5],
    sulawesi: [118.5, 126, -6.5, 2.5],
    nusa: [114, 129, -12, -7],
    maluku: [124, 135, -9, 2.5],
    papua: [130, 142, -10, 2]
  };
  var demStep = .05;

  function demTileName(longitude, latitude) {
    var west = Math.floor(longitude / 15) * 15;
    var westText = String(west).padStart(3, '0');
    var north = latitude > 0 ? 15 : 0;
    return 'etopo-n' + String(north).padStart(2, '0') + 'e' + westText;
  }

  function getDemTile(name) {
    if (!demGridCache.has(name)) {
      demGridCache.set(name, fetch('assets/geodata/' + name + '.bin').then(function(response) {
        if (!response.ok) throw new Error('DEM tile tidak tersedia: ' + name);
        return response.arrayBuffer();
      }).then(function(buffer) {
        return { view: new DataView(buffer), width: 300 };
      }));
    }
    return demGridCache.get(name);
  }

  function sampleDem(grids, longitude, latitude) {
    var name = demTileName(longitude, latitude);
    var tile = grids[name];
    if (!tile) return 0;
    var west = Math.floor(longitude / 15) * 15;
    var north = latitude > 0 ? 15 : 0;
    var x = Math.max(0, Math.min(299, Math.round((longitude - west) / demStep)));
    var y = Math.max(0, Math.min(299, Math.round((north - latitude) / demStep)));
    return tile.view.getFloat32((y * tile.width + x) * 4, true);
  }

  function colorForElevation(meters) {
    if (meters > 3200) return '#e6eee0';
    if (meters > 1800) return '#d7e6cc';
    if (meters > 700) return '#a6c58f';
    if (meters > 120) return '#669767';
    return '#39765a';
  }

  function addElevationMesh(target, sourcePath, box, viewBox, baseDepth, island, region, samples, rows) {
    var columns = samples.length - 1;
    var rowCount = samples[0].length - 1;
    var maxHeight = 100;
    samples.forEach(function(row) { row.forEach(function(value) { if (value > maxHeight) maxHeight = value; }); });
    var zScale = 42 / maxHeight;
    var trianglesByLevel = new Map();
    function addTriangle(p1, p2, p3, elevation) {
      var cx = (p1.x + p2.x + p3.x) / 3;
      var cy = (p1.y + p2.y + p3.y) / 3;
      try { if (!sourcePath.isPointInFill(new DOMPoint(cx, cy))) return; } catch (error) { return; }
      var height = Math.max(0, elevation);
      var level = Math.round(height * zScale / 1.5);
      if (!trianglesByLevel.has(level)) trianglesByLevel.set(level, []);
      var points = [p1, p2, p3].map(function(p) { return p.x.toFixed(2) + ',' + p.y.toFixed(2); }).join(' ');
      trianglesByLevel.get(level).push({ points:points, fill:colorForElevation(height) });
    }

    for (var y = 0; y < rowCount; y++) for (var x = 0; x < columns; x++) {
      var lon0 = region[0] + (region[1] - region[0]) * x / columns;
      var lon1 = region[0] + (region[1] - region[0]) * (x + 1) / columns;
      var lat0 = region[3] - (region[3] - region[2]) * y / rowCount;
      var lat1 = region[3] - (region[3] - region[2]) * (y + 1) / rowCount;
      var x0 = box.x + box.width * x / columns, x1 = box.x + box.width * (x + 1) / columns;
      var y0 = box.y + box.height * y / rowCount, y1 = box.y + box.height * (y + 1) / rowCount;
      var e00 = samples[x][y], e10 = samples[x + 1][y], e01 = samples[x][y + 1], e11 = samples[x + 1][y + 1];
      addTriangle({x:x0,y:y0},{x:x1,y:y0},{x:x0,y:y1},(e00+e10+e01)/3);
      addTriangle({x:x1,y:y0},{x:x1,y:y1},{x:x0,y:y1},(e10+e11+e01)/3);
    }

    var id = 'dem-land-' + island;
    trianglesByLevel.forEach(function(triangles, level) {
      var layer = makeSvg('svg', { class:'island-model-layer dem-terrain-layer', viewBox:viewBox, preserveAspectRatio:'none', 'aria-hidden':'true' });
      layer.style.transform = 'translateZ(' + (baseDepth + 1 + level * 1.5) + 'px)';
      var defs = makeSvg('defs');
      var clip = makeSvg('clipPath', { id:id + '-' + level });
      clip.appendChild(makeSvg('path', { d:sourcePath.getAttribute('d') }));
      defs.appendChild(clip); layer.appendChild(defs);
      var group = makeSvg('g', { 'clip-path':'url(#' + id + '-' + level + ')' });
      triangles.forEach(function(triangle) {
        group.appendChild(makeSvg('polygon', { points:triangle.points, fill:triangle.fill }));
      });
      layer.appendChild(group); target.appendChild(layer);
    });
  }

  function drawBathymetry(samples) {
    var root = document.querySelector('.bathymetry-generated');
    root.replaceChildren();
    var levels = [-200, -500, -1000, -2000, -4000];
    var columns = samples.length - 1, rows = samples[0].length - 1;
    levels.forEach(function(level, index) {
      var pathData = [];
      function cross(a, b, va, vb) {
        if ((va < level) === (vb < level)) return null;
        var t = (level - va) / (vb - va);
        return { x:(a.x + (b.x - a.x) * t) * 540 + 30, y:(a.y + (b.y - a.y) * t) * 300 + 30 };
      }
      for (var y=0;y<rows;y++) for(var x=0;x<columns;x++) {
        var v=[samples[x][y],samples[x+1][y],samples[x+1][y+1],samples[x][y+1]];
        var p=[{x:x/columns,y:y/rows},{x:(x+1)/columns,y:y/rows},{x:(x+1)/columns,y:(y+1)/rows},{x:x/columns,y:(y+1)/rows}];
        var intersections=[];
        for(var edge=0;edge<4;edge++) { var point=cross(p[edge],p[(edge+1)%4],v[edge],v[(edge+1)%4]); if(point) intersections.push(point); }
        for(var k=0;k+1<intersections.length;k+=2) pathData.push('M'+intersections[k].x.toFixed(1)+' '+intersections[k].y.toFixed(1)+'L'+intersections[k+1].x.toFixed(1)+' '+intersections[k+1].y.toFixed(1));
      }
      if (pathData.length) root.appendChild(makeSvg('path', { d:pathData.join(''), fill:'none', stroke:'rgba(147,211,199,'+(0.3+index*.08)+')', 'stroke-width':index<2?1:1.35, 'vector-effect':'non-scaling-stroke' }));
    });
    levels.forEach(function(level,index){
      root.appendChild(makeSvg('text',{x:42+index*94,y:338,fill:'rgba(220,244,241,.82)',style:'font:700 9px sans-serif'})).textContent=level.toLocaleString('id-ID')+' m';
    });
  }

  async function loadElevationModel(island, sourcePath, box, viewBox, baseDepth, revision) {
    var region = islandRegions[island];
    if (!region) throw new Error('Batas wilayah DEM tidak tersedia.');
    var columns = 56, rows = 40, tileNames = new Set();
    for(var x=0;x<=columns;x++) for(var y=0;y<=rows;y++) {
      var lon=region[0]+(region[1]-region[0])*x/columns;
      var lat=region[3]-(region[3]-region[2])*y/rows;
      tileNames.add(demTileName(lon,lat));
    }
    var loaded = await Promise.all(Array.from(tileNames).map(async function(name){return [name,await getDemTile(name)];}));
    var grids={}; loaded.forEach(function(entry){grids[entry[0]]=entry[1];});
    var samples=Array.from({length:columns+1},function(_,x){return Array.from({length:rows+1},function(_,y){
      var lon=region[0]+(region[1]-region[0])*x/columns;
      var lat=region[3]-(region[3]-region[2])*y/rows;
      return sampleDem(grids,lon,lat);
    });});
    if (revision !== modelRevision) return;
    addElevationMesh(stack,sourcePath,box,viewBox,baseDepth,island,region,samples,rows);
    drawBathymetry(samples);
  }

  function addLowPolyTrees(target, sourcePath, box, viewBox, baseDepth) {
    var inside = function(x, y) {
      try { return sourcePath.isPointInFill(new DOMPoint(x, y)); } catch (error) { return false; }
    };
    var trees = [];
    for (var attempt = 0; attempt < 220 && trees.length < 5; attempt++) {
      var x = box.x + box.width * (.12 + Math.random() * .76);
      var y = box.y + box.height * (.2 + Math.random() * .62);
      if (!inside(x, y) || trees.some(function(tree) { return Math.abs(tree.x - x) < box.width * .13; })) continue;
      trees.push({ x: x, y: y, h: Math.max(18, Math.min(42, box.height * .34, box.width * .1)) });
    }
    if (!trees.length) trees.push({ x: box.x + box.width * .5, y: box.y + box.height * .52, h: Math.max(20, Math.min(38, box.height * .3)) });

    trees.forEach(function(tree) {
      var halfWidth = Math.max(5, Math.min(tree.h * .31, box.height * .1));
      var baseY = tree.y + tree.h * .2;
      var trunk = makeSvg('svg', { class: 'island-model-layer lowpoly-tree', viewBox: viewBox, preserveAspectRatio: 'none', 'aria-hidden': 'true' });
      trunk.style.transform = 'translateZ(' + (baseDepth + 1) + 'px)';
      trunk.appendChild(makeSvg('polygon', { class: 'tree-trunk', points: (tree.x - halfWidth * .16) + ',' + baseY + ' ' + (tree.x - halfWidth * .1) + ',' + (baseY - tree.h * .3) + ' ' + (tree.x + halfWidth * .1) + ',' + (baseY - tree.h * .3) + ' ' + (tree.x + halfWidth * .16) + ',' + baseY }));
      target.appendChild(trunk);

      for (var layer = 1; layer <= 7; layer++) {
        var rise = layer / 7;
        var widthAt = halfWidth * (1 - rise * .78);
        var peakY = baseY - tree.h * rise;
        var canopy = makeSvg('svg', { class: 'island-model-layer lowpoly-tree', viewBox: viewBox, preserveAspectRatio: 'none', 'aria-hidden': 'true' });
        canopy.style.transform = 'translateZ(' + (baseDepth + 2 + tree.h * rise) + 'px)';
        var left = (tree.x - widthAt) + ',' + baseY;
        var tip = tree.x + ',' + peakY;
        var right = (tree.x + widthAt) + ',' + baseY;
        var middle = tree.x + ',' + baseY;
        canopy.appendChild(makeSvg('polygon', { class: 'tree-light', points: left + ' ' + tip + ' ' + middle }));
        canopy.appendChild(makeSvg('polygon', { class: 'tree-shadow', points: tip + ' ' + right + ' ' + middle }));
        if (layer === 4) canopy.appendChild(makeSvg('polygon', { class: 'tree-mid', points: (tree.x - halfWidth * .7) + ',' + (baseY - tree.h * .42) + ' ' + tree.x + ',' + (baseY - tree.h * .75) + ' ' + (tree.x + halfWidth * .7) + ',' + (baseY - tree.h * .42) }));
        target.appendChild(canopy);
      }
    });
  }

  async function buildModel(sourcePath, island, revision) {
    stack.replaceChildren();
    var box = sourcePath.getBBox();
    var padX = Math.max(10, box.width * .035), padY = Math.max(10, box.height * .12);
    var viewBox = [box.x - padX, box.y - padY, box.width + padX * 2, box.height + padY * 2].join(' ');
    var scale = Math.min(340 / (box.width + padX * 2), 190 / (box.height + padY * 2));
    stack.style.width = Math.max(70, (box.width + padX * 2) * scale) + 'px';
    stack.style.height = Math.max(42, (box.height + padY * 2) * scale) + 'px';

    var depth = 22;
    for (var layer = 0; layer <= depth; layer++) {
      var face = makeSvg('svg', { class: 'island-model-layer' + (layer === depth ? ' island-model-top' : ''), viewBox: viewBox, preserveAspectRatio: 'none', 'aria-hidden': 'true' });
      face.style.transform = 'translateZ(' + layer + 'px)';
      var d = makeSvg('defs');
      var gradient = makeSvg('linearGradient', { id: 'islandLandGradient', x1: '0', y1: '0', x2: '1', y2: '1' });
      gradient.appendChild(makeSvg('stop', { offset: '0%', 'stop-color': '#dce8cc' }));
      gradient.appendChild(makeSvg('stop', { offset: '48%', 'stop-color': '#86b77f' }));
      gradient.appendChild(makeSvg('stop', { offset: '100%', 'stop-color': '#3c765a' }));
      d.appendChild(gradient);
      face.appendChild(d);
      face.appendChild(makeSvg('path', { d: sourcePath.getAttribute('d'), fill: layer === depth ? 'url(#islandLandGradient)' : (layer > depth - 4 ? '#3f755b' : '#274d40') }));
      stack.appendChild(face);
    }
    var rockPalette = ['#526d56','#465f4d','#3d5547','#344a40','#2b4038','#23372f','#1c3029'];
    for (var under = 1; under <= 34; under++) {
      var taper = 1 - (under / 36) * .92;
      var rockLayer = makeSvg('svg', { class: 'island-model-layer island-underbelly', viewBox: viewBox, preserveAspectRatio: 'none', 'aria-hidden': 'true' });
      rockLayer.style.transformBox = 'view-box';
      rockLayer.style.transformOrigin = '50% 50%';
      rockLayer.style.transform = 'translateZ(' + (-under * 1.8) + 'px) scale(' + taper + ')';
      rockLayer.appendChild(makeSvg('path', { d: sourcePath.getAttribute('d'), fill: rockPalette[Math.min(rockPalette.length - 1, Math.floor(under / 5))] }));
      stack.appendChild(rockLayer);
    }
    await loadElevationModel(island, sourcePath, box, viewBox, depth, revision);
  }

  function openModel(button) {
    var island = button.getAttribute('data-island');
    var map = button.closest('.indo-map');
    var sourcePath = map && map.querySelector('.outline-' + island);
    if (!sourcePath) return;
    returnFocus = button;
    var revision = ++modelRevision;
    title.textContent = button.getAttribute('aria-label') + ' • Model 3D';
    stack.setAttribute('aria-busy','true');
    var caption = document.querySelector('.island-3d-caption span');
    caption.firstChild.textContent = 'Memuat data elevasi NOAA… ';
    buildModel(sourcePath, island, revision).then(function() {
      if (revision !== modelRevision) return;
      stack.removeAttribute('aria-busy');
      caption.firstChild.textContent = 'Seret untuk memutar • grid elevasi dan batimetri lokal • ';
    }).catch(function(error) {
      if (revision !== modelRevision) return;
      stack.removeAttribute('aria-busy');
      caption.firstChild.textContent = 'Data relief gagal dimuat • ';
      console.error(error);
    });
    rotationX = 60;
    rotationY = -18;
    applyRotation();
    modal.classList.add('open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    closeButton.focus();
  }

  function closeModel() {
    modelRevision++;
    modal.classList.remove('open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    if (returnFocus) returnFocus.focus();
  }

  document.querySelectorAll('.island-hotspot').forEach(function(button) {
    button.addEventListener('click', function() { openModel(button); });
  });
  closeButton.addEventListener('click', closeModel);
  modal.addEventListener('click', function(event) { if (event.target === modal) closeModel(); });
  document.addEventListener('keydown', function(event) { if (event.key === 'Escape' && modal.classList.contains('open')) closeModel(); });
  resetButton.addEventListener('click', function() { rotationX = 60; rotationY = -18; applyRotation(); });

  stage.addEventListener('pointerdown', function(event) {
    if (event.target.closest('button')) return;
    dragging = true;
    startX = event.clientX; startY = event.clientY;
    startRotationX = rotationX; startRotationY = rotationY;
    stage.classList.add('dragging');
    stage.setPointerCapture(event.pointerId);
  });
  stage.addEventListener('pointermove', function(event) {
    if (!dragging) return;
    rotationY = startRotationY + (event.clientX - startX) * .65;
    rotationX = startRotationX - (event.clientY - startY) * .65;
    applyRotation();
  });
  function stopDragging() { dragging = false; stage.classList.remove('dragging'); }
  stage.addEventListener('pointerup', stopDragging);
  stage.addEventListener('pointercancel', stopDragging);
})();
</script>

<!-- Toggle script inline (selalu di akhir body) -->

<script>
  (function() {
    var btn = document.getElementById('btnToggleKota');
    var rows = document.querySelectorAll('.kota-extra');
    var showing = false;
    if (btn && rows.length) {
      btn.onclick = function(e) {
        e.preventDefault();
        e.stopPropagation();
        showing = !showing;
        rows.forEach(function(r) {
          r.style.display = showing ? 'table-row' : 'none';
        });
        btn.textContent = showing ? ' Tampilkan lebih sedikit (10 kota)' : ' Lihat selengkapnya (70 kota)';
      };
    }
  })();
</script>


<script>
  document.querySelectorAll('.indo-map').forEach(function(map) {
    map.querySelectorAll('.island-hotspot').forEach(function(hotspot) {
      var island = hotspot.className.match(/hotspot-([a-z]+)/)[1];
      function highlight() {
        map.className = map.className.replace(/\bhighlight-[a-z]+\b/g, '').trim();
        map.classList.add('highlight-' + island);
      }
      function clearHighlight() {
        map.classList.remove('highlight-' + island);
      }
      hotspot.addEventListener('mouseenter', highlight);
      hotspot.addEventListener('mouseleave', function() {
        if (!hotspot.matches(':focus')) clearHighlight();
      });
      hotspot.addEventListener('focus', highlight);
      hotspot.addEventListener('blur', clearHighlight);
    });
  });
</script>

<script src="script.js?v=20261107-4"></script>
</body>
</html>
