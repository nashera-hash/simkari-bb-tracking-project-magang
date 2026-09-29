@extends('layouts.app')

@section('title', 'Beranda')

@section('tabs')
    <a href="{{ route('dashboard') }}" class="active">Ringkasan</a>
@endsection

@section('content')
    <h1>Selamat Datang, {{ auth()->user()->name }}</h1>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-box">
                <small class="text-muted">Total barang bukti</small>
                <div class="fs-2 fw-semibold" style="color:var(--heading)">{{ $totalBarang }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box">
                <small class="text-muted">Total perkara</small>
                <div class="fs-2 fw-semibold" style="color:var(--heading)">{{ $totalPerkara }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-box">
                <small class="text-muted">Total gudang</small>
                <div class="fs-2 fw-semibold" style="color:var(--heading)">{{ $totalGudang }}</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card-box h-100">
                <h6 class="text-muted mb-3">Barang bukti per status</h6>
                @forelse (\App\Models\BarangBukti::STATUS as $key => $label)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $label }}</span>
                        <span class="pill">{{ $perStatus[$key] ?? 0 }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada data.</p>
                @endforelse
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-box h-100">
                <h6 class="text-muted mb-3">Barang bukti per gudang</h6>
                @forelse ($perGudang as $g)
                    <div class="d-flex justify-content-between border-bottom py-2">
                        <span>{{ $g->nama }}</span>
                        <span class="pill">{{ $g->barang_buktis_count }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">Belum ada gudang.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card-box">
        <h6 class="text-muted mb-3">5 barang bukti terbaru</h6>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama barang</th>
                        <th>Perkara</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($terbaru as $barang)
                        <tr>
                            <td><a href="{{ route('barang-bukti.show', $barang) }}">{{ $barang->kode }}</a></td>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->perkara->nomor_perkara }}</td>
                            <td>{{ $barang->gudang?->nama ?? 'Belum ditempatkan' }}{{ $barang->rak ? ', '.$barang->rak->kode : '' }}</td>
                            <td><span class="pill">{{ \App\Models\BarangBukti::STATUS[$barang->status] ?? $barang->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data barang bukti.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection