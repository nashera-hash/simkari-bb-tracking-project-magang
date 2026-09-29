<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\RiwayatLokasi;
use Illuminate\Http\Request;

class RiwayatLokasiController extends Controller
{
    public function index(Request $request)
    {
        $riwayats = RiwayatLokasi::with(['barangBukti', 'gudang', 'rak', 'user'])
            ->when($request->gudang_id, fn ($q, $id) => $q->where('gudang_id', $id))
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->q, function ($q, $val) {
                $q->whereHas('barangBukti', function ($sub) use ($val) {
                    $sub->where('kode', 'like', "%{$val}%")
                        ->orWhere('nama_barang', 'like', "%{$val}%");
                });
            })
            ->latest('waktu')
            ->paginate(15)
            ->withQueryString();

        $gudangs = Gudang::orderBy('nama')->get();

        return view('riwayat-lokasi.index', compact('riwayats', 'gudangs'));
    }
}