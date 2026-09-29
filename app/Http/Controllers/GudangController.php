<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        $gudangs = Gudang::withCount(['raks', 'barangBuktis'])
            ->when($request->q, fn ($query, $q) => $query->where('nama', 'like', "%{$q}%"))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('gudang.index', compact('gudangs'));
    }

    public function create()
    {
        return view('gudang.create');
    }

    public function store(Request $request)
    {
        Gudang::create($this->validated($request));

        return redirect()->route('gudang.index')->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function edit(Gudang $gudang)
    {
        return view('gudang.edit', compact('gudang'));
    }

    public function update(Request $request, Gudang $gudang)
    {
        $gudang->update($this->validated($request));

        return redirect()->route('gudang.index')->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(Gudang $gudang)
    {
        if ($gudang->raks()->exists() || $gudang->barangBuktis()->exists()) {
            return back()->with('error', 'Gudang tidak bisa dihapus karena masih memiliki rak atau barang bukti.');
        }

        $gudang->delete();

        return redirect()->route('gudang.index')->with('success', 'Gudang berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => 'required|string|max:100',
            'keterangan' => 'nullable|string|max:255',
        ]);
    }
}