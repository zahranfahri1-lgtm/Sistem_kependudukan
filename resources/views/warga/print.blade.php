<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Cetak Laporan Penduduk</title><link rel="stylesheet" href="{{ asset('style.css') }}"></head><body onload="window.print()">
<div class="container"><h2>Laporan Data Penduduk ({{ now()->format('d/m/Y') }})</h2>
<table class="data-table"><thead><tr><th>No</th><th>NIK</th><th>Nama</th><th>JK</th><th>Agama</th><th>Provinsi</th></tr></thead><tbody>
@foreach($wargas as $i => $w)<tr><td>{{ $i+1 }}</td><td>{{ $w->nik }}</td><td>{{ $w->nama }}</td><td>{{ $w->jenisKelamin?->nama }}</td><td>{{ $w->agama?->nama }}</td><td>{{ $w->provinsi?->nama ?? '-' }}</td></tr>@endforeach
</tbody></table></div></body></html>