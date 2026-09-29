@extends('layouts.app')

@section('title', 'Data Gudang')

@section('tabs')
    <a href="{{ route('gudang.index') }}" class="active">Data Gudang</a>
    <a href="{{ route('gudang.create') }}">Tambah Gudang</a>
@endsection

@section('content')
    <h1>Data Gudang</h1>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form method="GET" action="{{ route('gudang.index') }}" class="d-flex gap-2">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama gudang">
            <button class="btn btn-oren">Cari</button>
            @if (request('q'))
                <a href="{{ route('gudang.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">Reset</a>
            @endif
        </form>
        <a href="{{ route('gudang.create') }}" class="btn btn-oren">
            <i class="bi bi-plus-lg"></i> Tambah gudang
        </a>
    </div>

    <p class="small text-muted mb-2">
        Menampilkan {{ $gudangs->firstItem() ?? 0 }}-{{ $gudangs->lastItem() ?? 0 }} dari {{ $gudangs->total() }} item.
    </p>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:60px">No</th>
                    <th>Nama gudang</th>
                    <th>Keterangan</th>
                    <th class="text-center">Jumlah rak</th>
                    <th class="text-center">Jumlah barang</th>
                    <th class="text-center" style="width:170px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gudangs as $gudang)
                    <tr>
                        <td>{{ $gudangs->firstItem() + $loop->index }}</td>
                        <td>{{ $gudang->nama }}</td>
                        <td>{{ $gudang->keterangan ?: '-' }}</td>
                        <td class="text-center">{{ $gudang->raks_count }}</td>
                        <td class="text-center">{{ $gudang->barang_buktis_count }}</td>
                        <td class="text-center">
                            <a href="{{ route('gudang.edit', $gudang) }}" class="btn btn-oren btn-sm">Ubah</a>
                            <form method="POST" action="{{ route('gudang.destroy', $gudang) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus gudang {{ $gudang->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data gudang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $gudangs->links() }}
@endsection