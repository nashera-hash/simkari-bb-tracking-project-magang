<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RakController extends Controller
{
    public function index(Request $request)
    {
        $raks = Rak::with('gudang')
            ->withCount('barangBuktis')
            ->when($request->gudang_id, fn ($query, $id) => $query->where('gudang_id', $id))
            ->when($request->q, fn ($query, $q) => $query->where('kode', 'like', "%{$q}%"))
            ->orderBy('gudang_id')
            ->orderBy('kode')
            ->paginate(10)
            ->withQueryString();

        $gudangs = Gudang::orderBy('nama')->get();

        return view('rak.index', compact('raks', 'gudangs'));
    }

    public function create()
    {
        $gudangs = Gudang::orderBy('nama')->get();

        return view('rak.create', compact('gudangs'));
    }

    public function store(Request $request)
    {
        Rak::create($this->validated($request));

        return redirect()->route('rak.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function edit(Rak $rak)
    {
        $gudangs = Gudang::orderBy('nama')->get();

        return view('rak.edit', compact('rak', 'gudangs'));
    }

    public function update(Request $request, Rak $rak)
    {
        $rak->update($this->validated($request, $rak));

        return redirect()->route('rak.index')->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rak $rak)
    {
        if ($rak->barangBuktis()->exists()) {
            return back()->with('error', 'Rak tidak bisa dihapus karena masih menyimpan barang bukti.');
        }

        $rak->delete();

        return redirect()->route('rak.index')->with('success', 'Rak berhasil dihapus.');
    }

    private function validated(Request $request, ?Rak $rak = null): array
    {
        return $request->validate([
            'gudang_id' => 'required|exists:gudangs,id',
            'kode' => [
                'required',
                'string',
                'max:50',
                Rule::unique('raks', 'kode')
                    ->where('gudang_id', $request->gudang_id)
                    ->ignore($rak?->id),
            ],
        ], [
            'gudang_id.required' => 'Pilih gudang terlebih dahulu.',
            'kode.unique' => 'Kode rak sudah dipakai di gudang ini.',
        ]);
    }
}