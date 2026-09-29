<?php

namespace App\Http\Controllers;

use App\Models\Perkara;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerkaraController extends Controller
{
    public function index(Request $request)
    {
        $perkaras = Perkara::withCount('barangBuktis')
            ->when($request->kategori, fn ($query, $k) => $query->where('kategori', $k))
            ->when($request->status, fn ($query, $s) => $query->where('status', $s))
            ->when($request->q, function ($query, $q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nomor_perkara', 'like', "%{$q}%")
                        ->orWhere('nama_terdakwa', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('perkara.index', compact('perkaras'));
    }

    public function create()
    {
        return view('perkara.create');
    }

    public function store(Request $request)
    {
        Perkara::create($this->validated($request));

        return redirect()->route('perkara.index')->with('success', 'Perkara berhasil ditambahkan.');
    }

    public function edit(Perkara $perkara)
    {
        return view('perkara.edit', compact('perkara'));
    }

    public function update(Request $request, Perkara $perkara)
    {
        $perkara->update($this->validated($request, $perkara));

        return redirect()->route('perkara.index')->with('success', 'Perkara berhasil diperbarui.');
    }

    public function destroy(Perkara $perkara)
    {
        if ($perkara->barangBuktis()->exists()) {
            return back()->with('error', 'Perkara tidak bisa dihapus karena masih memiliki barang bukti.');
        }

        $perkara->delete();

        return redirect()->route('perkara.index')->with('success', 'Perkara berhasil dihapus.');
    }

    private function validated(Request $request, ?Perkara $perkara = null): array
    {
        return $request->validate([
            'nomor_perkara' => [
                'required',
                'string',
                'max:100',
                Rule::unique('perkaras', 'nomor_perkara')->ignore($perkara?->id),
            ],
            'nama_terdakwa' => 'required|string|max:150',
            'jaksa' => 'nullable|string|max:150',
            'kategori' => ['required', Rule::in(array_keys(Perkara::KATEGORI))],
            'status' => ['required', Rule::in(array_keys(Perkara::STATUS))],
        ], [
            'nomor_perkara.unique' => 'Nomor perkara sudah terdaftar.',
            'kategori.required' => 'Pilih kategori perkara.',
            'status.required' => 'Pilih status perkara.',
        ]);
    }
}