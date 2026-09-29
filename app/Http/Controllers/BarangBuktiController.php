<?php

namespace App\Http\Controllers;

use App\Models\BarangBukti;
use App\Models\Gudang;
use App\Models\Perkara;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BarangBuktiController extends Controller
{
    public function index(Request $request)
    {
        $barangs = BarangBukti::with(['perkara', 'gudang', 'rak'])
            ->when($request->status, fn ($q, $s) => $q->where('status', $s))
            ->when($request->gudang_id, fn ($q, $id) => $q->where('gudang_id', $id))
            ->when($request->q, function ($q, $val) {
                $q->where(function ($sub) use ($val) {
                    $sub->where('kode', 'like', "%{$val}%")
                        ->orWhere('nama_barang', 'like', "%{$val}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $gudangs = Gudang::orderBy('nama')->get();

        return view('barang-bukti.index', compact('barangs', 'gudangs'));
    }

    public function create()
    {
        $perkaras = Perkara::orderBy('nomor_perkara')->get();
        $gudangs = Gudang::with('raks')->orderBy('nama')->get();

        return view('barang-bukti.create', compact('perkaras', 'gudangs'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        DB::transaction(function () use ($data) {
            $barang = BarangBukti::create($data);

            $barang->riwayat()->create([
                'gudang_id' => $barang->gudang_id,
                'rak_id' => $barang->rak_id,
                'status' => $barang->status,
                'user_id' => Auth::id(),
                'keterangan' => 'Barang bukti pertama kali didaftarkan.',
            ]);
        });

        return redirect()->route('barang-bukti.index')->with('success', 'Barang bukti berhasil ditambahkan.');
    }

    public function show(BarangBukti $barangBukti)
    {
        $barangBukti->load(['perkara', 'gudang', 'rak', 'riwayat.gudang', 'riwayat.rak', 'riwayat.user']);

        return view('barang-bukti.show', ['barang' => $barangBukti]);
    }

    public function edit(BarangBukti $barangBukti)
    {
        $perkaras = Perkara::orderBy('nomor_perkara')->get();

        return view('barang-bukti.edit', ['barang' => $barangBukti, 'perkaras' => $perkaras]);
    }

    public function update(Request $request, BarangBukti $barangBukti)
    {
        $data = $request->validate([
            'perkara_id' => 'required|exists:perkaras,id',
            'nama_barang' => 'required|string|max:150',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'nullable|string|max:30',
            'kondisi' => 'nullable|string|max:100',
        ]);

        $barangBukti->update($data);

        return redirect()->route('barang-bukti.index')->with('success', 'Barang bukti berhasil diperbarui.');
    }

    public function destroy(BarangBukti $barangBukti)
    {
        $barangBukti->delete();

        return redirect()->route('barang-bukti.index')->with('success', 'Barang bukti berhasil dihapus.');
    }

    public function pindahForm(BarangBukti $barangBukti)
    {
        $gudangs = Gudang::with('raks')->orderBy('nama')->get();

        return view('barang-bukti.pindah', ['barang' => $barangBukti, 'gudangs' => $gudangs]);
    }

    public function pindahSimpan(Request $request, BarangBukti $barangBukti)
    {
        $data = $request->validate([
            'gudang_id' => 'nullable|exists:gudangs,id',
            'rak_id' => 'nullable|exists:raks,id',
            'status' => ['required', Rule::in(array_keys(BarangBukti::STATUS))],
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($barangBukti, $data) {
            $barangBukti->update([
                'gudang_id' => $data['gudang_id'],
                'rak_id' => $data['rak_id'],
                'status' => $data['status'],
            ]);

            $barangBukti->riwayat()->create([
                'gudang_id' => $data['gudang_id'],
                'rak_id' => $data['rak_id'],
                'status' => $data['status'],
                'user_id' => Auth::id(),
                'keterangan' => $data['keterangan'],
            ]);
        });

        return redirect()->route('barang-bukti.show', $barangBukti)->with('success', 'Lokasi barang bukti berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'perkara_id' => 'required|exists:perkaras,id',
            'kode' => 'required|string|max:50|unique:barang_buktis,kode',
            'nama_barang' => 'required|string|max:150',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'nullable|string|max:30',
            'kondisi' => 'nullable|string|max:100',
            'status' => ['required', Rule::in(array_keys(BarangBukti::STATUS))],
            'gudang_id' => 'nullable|exists:gudangs,id',
            'rak_id' => 'nullable|exists:raks,id',
        ], [
            'kode.unique' => 'Kode barang bukti sudah dipakai.',
        ]);
    }
}