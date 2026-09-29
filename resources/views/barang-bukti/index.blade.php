@extends('layouts.app')

@section('title', 'Data Barang Bukti')

@section('tabs')
    <a href="{{ route('barang-bukti.index') }}" class="active">Data Barang Bukti</a>
    <a href="{{ route('barang-bukti.create') }}">Tambah Barang Bukti</a>
@endsection

@section('content')
    <h1>Data Barang Bukti</h1>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form method="GET" action="{{ route('barang-bukti.index') }}" class="d-flex gap-2 flex-wrap">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" style="width:220px"
                   placeholder="Cari kode / nama barang">
            <select name="gudang_id" class="form-select" style="width:170px">
                <option value="">Semua gudang</option>
                @foreach ($gudangs as $g)
                    <option value="{{ $g->id }}" @selected(request('gudang_id') == $g->id)>{{ $g->nama }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select" style="width:160px">
                <option value="">Semua status</option>
                @foreach (\App\Models\BarangBukti::STATUS as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn btn-oren">Cari</button>
            @if (request('q') || request('gudang_id') || request('status'))
                <a href="{{ route('barang-bukti.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">Reset</a>
            @endif
        </form>
        <a href="{{ route('barang-bukti.create') }}" class="btn btn-oren">
            <i class="bi bi-plus-lg"></i> Tambah barang
        </a>
    </div>

    <p class="small text-muted mb-2">
        Menampilkan {{ $barangs->firstItem() ?? 0 }}-{{ $barangs->lastItem() ?? 0 }} dari {{ $barangs->total() }} item.
    </p>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:60px">No</th>
                    <th>Kode</th>
                    <th>Nama barang</th>
                    <th>Perkara</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th class="text-center" style="width:220px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td>{{ $barangs->firstItem() + $loop->index }}</td>
                        <td>{{ $barang->kode }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->perkara->nomor_perkara }}</td>
                        <td>
                            @if ($barang->gudang)
                                {{ $barang->gudang->nama }}{{ $barang->rak ? ', '.$barang->rak->kode : '' }}
                            @else
                                <span class="text-muted">Belum ditempatkan</span>
                            @endif
                        </td>
                        <td>
                            <span class="pill">{{ \App\Models\BarangBukti::STATUS[$barang->status] ?? $barang->status }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('barang-bukti.show', $barang) }}" class="btn btn-outline-secondary btn-sm">Detail</a>
                            <a href="{{ route('barang-bukti.pindah', $barang) }}" class="btn btn-oren btn-sm">Pindah</a>
                            <form method="POST" action="{{ route('barang-bukti.destroy', $barang) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus barang {{ $barang->kode }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data barang bukti.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $barangs->links() }}
@endsection