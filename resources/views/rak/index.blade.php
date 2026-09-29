@extends('layouts.app')

@section('title', 'Data Rak')

@section('tabs')
    <a href="{{ route('rak.index') }}" class="active">Data Rak</a>
    <a href="{{ route('rak.create') }}">Tambah Rak</a>
@endsection

@section('content')
    <h1>Data Rak</h1>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form method="GET" action="{{ route('rak.index') }}" class="d-flex gap-2 flex-wrap">
            <select name="gudang_id" class="form-select" style="width:200px">
                <option value="">Semua gudang</option>
                @foreach ($gudangs as $g)
                    <option value="{{ $g->id }}" @selected(request('gudang_id') == $g->id)>{{ $g->nama }}</option>
                @endforeach
            </select>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" style="width:200px" placeholder="Cari kode rak">
            <button class="btn btn-oren">Cari</button>
            @if (request('q') || request('gudang_id'))
                <a href="{{ route('rak.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">Reset</a>
            @endif
        </form>
        <a href="{{ route('rak.create') }}" class="btn btn-oren">
            <i class="bi bi-plus-lg"></i> Tambah rak
        </a>
    </div>

    <p class="small text-muted mb-2">
        Menampilkan {{ $raks->firstItem() ?? 0 }}-{{ $raks->lastItem() ?? 0 }} dari {{ $raks->total() }} item.
    </p>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:60px">No</th>
                    <th>Gudang</th>
                    <th>Kode rak</th>
                    <th class="text-center">Jumlah barang</th>
                    <th class="text-center" style="width:170px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($raks as $rak)
                    <tr>
                        <td>{{ $raks->firstItem() + $loop->index }}</td>
                        <td>{{ $rak->gudang->nama }}</td>
                        <td>{{ $rak->kode }}</td>
                        <td class="text-center">{{ $rak->barang_buktis_count }}</td>
                        <td class="text-center">
                            <a href="{{ route('rak.edit', $rak) }}" class="btn btn-oren btn-sm">Ubah</a>
                            <form method="POST" action="{{ route('rak.destroy', $rak) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus rak {{ $rak->kode }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data rak.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $raks->links() }}
@endsection