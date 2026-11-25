<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Support\Facades\DB;

class PublicPagesController extends Controller
{
    private function chartData(string $table, string $col)
    {
        return DB::table('warga')
            ->join($table, "warga.{$col}", '=', "{$table}.id")
            ->select("{$table}.nama as label", DB::raw('COUNT(*) as total'))
            ->groupBy("{$table}.id", "{$table}.nama")
            ->orderByDesc('total')
            ->get();
    }

    public function stats()
    {
        return view('pages.stats', [
            'charts' => [
                'Warga per Agama' => $this->chartData('agama', 'agama_id'),
                'Warga per Jenis Kelamin' => $this->chartData('jenis_kelamin', 'jenis_kelamin_id'),
                'Warga per Pekerjaan' => $this->chartData('pekerjaan', 'pekerjaan_id'),
                'Warga per Pendidikan' => $this->chartData('pendidikan_terakhir', 'pendidikan_id'),
                'Warga per Golongan Darah' => $this->chartData('golongan_darah', 'golongan_darah_id'),
                'Warga per Status Pernikahan' => $this->chartData('status_pernikahan', 'status_pernikahan_id'),
            ],
        ]);
    }

    public function populasi()
    {
        return view('pages.populasi', [
            'provinsiCounts' => DB::table('warga')
                ->join('provinsi', 'warga.provinsi_id', '=', 'provinsi.id')
                ->select('provinsi.nama', DB::raw('COUNT(*) as total'))
                ->groupBy('provinsi.nama')
                ->pluck('total', 'nama')
                ->toArray(),
            'totalPenduduk' => Warga::count(),
        ]);
    }

    public function about()
    {
        return view('pages.about');
    }
}