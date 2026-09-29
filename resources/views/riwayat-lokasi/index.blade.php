@extends('layouts.app')

@section('title', 'Riwayat Lokasi')

@section('tabs')
    <a href="{{ route('riwayat-lokasi.index') }}" class="active">Semua Riwayat Lokasi</a>
@endsection

@section('content')
    <h1>Riwayat Lokasi</h1>

    <form method="GET" action="{{ route('riwayat-lokasi.index') }}" class="d-flex gap-2 flex-wrap mb-3">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" style="width:220px"
               placeholder="Cari kode / nama barang">
        <select name="gudang_id" class="form-select" style="width:180px">
            <option value="">Semua gudang</option>
            @foreach ($gudangs as $g)
                <option value="{{ $g->id }}" @selected(request('gudang_id') == $g->id)>{{ $g->nama }}</option>
            @endforeach
        </select>
        <select name="status" class="form-select" style="width:170px">
            <option value="">Semua status</option>
            @foreach (\App\Models\BarangBukti::STATUS as $key => $label)
                <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn btn-oren">Cari</button>
        @if (request('q') || request('gudang_id') || request('status'))
            <a href="{{ route('riwayat-lokasi.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">Reset</a>
        @endif
    </form>

    <p class="small text-muted mb-2">
        Menampilkan {{ $riwayats->firstItem() ?? 0 }}-{{ $riwayats->lastItem() ?? 0 }} dari {{ $riwayats->total() }} item.
    </p>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Kode</th>
                    <th>Nama barang</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayats as $r)
                    <tr>
                        <td>{{ $r->waktu->translatedFormat('d M Y, H:i') }}</td>
                        <td><a href="{{ route('barang-bukti.show', $r->barang_bukti_id) }}">{{ $r->barangBukti->kode }}</a></td>
                        <td>{{ $r->barangBukti->nama_barang }}</td>
                        <td>{{ $r->gudang?->nama ?? 'Belum ditempatkan' }}{{ $r->rak ? ', '.$r->rak->kode : '' }}</td>
                        <td><span class="pill">{{ \App\Models\BarangBukti::STATUS[$r->status] ?? $r->status }}</span></td>
                        <td>{{ $r->user->name }}</td>
                        <td>{{ $r->keterangan ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada riwayat lokasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $riwayats->links() }}
@endsection