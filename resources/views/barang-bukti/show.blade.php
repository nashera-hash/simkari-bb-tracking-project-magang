@extends('layouts.app')

@section('title', 'Detail Barang Bukti')

@section('tabs')
    <a href="{{ route('barang-bukti.index') }}">Data Barang Bukti</a>
    <a href="{{ route('barang-bukti.show', $barang) }}" class="active">Detail</a>
@endsection

@section('content')
    <h1>{{ $barang->kode }} - {{ $barang->nama_barang }}</h1>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card-box h-100">
                <h6 class="text-muted mb-3">Informasi barang</h6>
                <table class="table table-borderless table-sm mb-0">
                    <tr><td class="text-muted" style="width:140px">Perkara</td><td>{{ $barang->perkara->nomor_perkara }} - {{ $barang->perkara->nama_terdakwa }}</td></tr>
                    <tr><td class="text-muted">Jumlah</td><td>{{ $barang->jumlah }} {{ $barang->satuan }}</td></tr>
                    <tr><td class="text-muted">Kondisi</td><td>{{ $barang->kondisi ?: '-' }}</td></tr>
                    <tr><td class="text-muted">Status</td><td><span class="pill">{{ \App\Models\BarangBukti::STATUS[$barang->status] ?? $barang->status }}</span></td></tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box h-100">
                <h6 class="text-muted mb-3">Lokasi saat ini</h6>
                @if ($barang->gudang)
                    <p class="mb-1"><strong>{{ $barang->gudang->nama }}</strong></p>
                    <p class="text-muted mb-3">{{ $barang->rak ? 'Rak '.$barang->rak->kode : 'Belum ditempatkan di rak' }}</p>
                @else
                    <p class="text-muted mb-3">Belum ditempatkan di gudang mana pun.</p>
                @endif
                <a href="{{ route('barang-bukti.pindah', $barang) }}" class="btn btn-oren btn-sm">Pindahkan / ubah status</a>
                <a href="{{ route('barang-bukti.edit', $barang) }}" class="btn btn-outline-secondary btn-sm">Ubah data barang</a>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Riwayat perpindahan</h5>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Petugas</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barang->riwayat as $r)
                    <tr>
                        <td>{{ $r->waktu->translatedFormat('d M Y, H:i') }}</td>
                        <td>{{ $r->gudang?->nama ?? 'Belum ditempatkan' }}{{ $r->rak ? ', '.$r->rak->kode : '' }}</td>
                        <td><span class="pill">{{ \App\Models\BarangBukti::STATUS[$r->status] ?? $r->status }}</span></td>
                        <td>{{ $r->user->name }}</td>
                        <td>{{ $r->keterangan ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada riwayat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection