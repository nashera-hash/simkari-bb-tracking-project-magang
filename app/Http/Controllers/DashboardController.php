<?php

namespace App\Http\Controllers;

use App\Models\BarangBukti;
use App\Models\Gudang;
use App\Models\Perkara;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = BarangBukti::count();
        $totalPerkara = Perkara::count();
        $totalGudang = Gudang::count();

        $perStatus = BarangBukti::selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $perGudang = Gudang::withCount('barangBuktis')
            ->orderByDesc('barang_buktis_count')
            ->get();

        $terbaru = BarangBukti::with(['perkara', 'gudang', 'rak'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('totalBarang', 'totalPerkara', 'totalGudang', 'perStatus', 'perGudang', 'terbaru'));
    }
}