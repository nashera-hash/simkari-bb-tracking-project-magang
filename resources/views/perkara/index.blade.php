@extends('layouts.app')

@section('title', 'Data Perkara')

@section('tabs')
    <a href="{{ route('perkara.index') }}" class="active">Data Perkara</a>
    <a href="{{ route('perkara.create') }}">Tambah Perkara</a>
@endsection

@section('content')
    <h1>Data Perkara</h1>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form method="GET" action="{{ route('perkara.index') }}" class="d-flex gap-2 flex-wrap">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" style="width:230px"
                   placeholder="Cari nomor perkara / terdakwa">
            <select name="kategori" class="form-select" style="width:170px">
                <option value="">Semua kategori</option>
                @foreach (\App\Models\Perkara::KATEGORI as $key => $label)
                    <option value="{{ $key }}" @selected(request('kategori') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select" style="width:150px">
                <option value="">Semua status</option>
                @foreach (\App\Models\Perkara::STATUS as $key => $label)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn btn-oren">Cari</button>
            @if (request('q') || request('kategori') || request('status'))
                <a href="{{ route('perkara.index') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center">Reset</a>
            @endif
        </form>
        <a href="{{ route('perkara.create') }}" class="btn btn-oren">
            <i class="bi bi-plus-lg"></i> Tambah perkara
        </a>
    </div>

    <p class="small text-muted mb-2">
        Menampilkan {{ $perkaras->firstItem() ?? 0 }}-{{ $perkaras->lastItem() ?? 0 }} dari {{ $perkaras->total() }} item.
    </p>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:60px">No</th>
                    <th>Nomor perkara</th>
                    <th>Nama terdakwa</th>
                    <th>Jaksa</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th class="text-center">Barang bukti</th>
                    <th class="text-center" style="width:170px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($perkaras as $perkara)
                    <tr>
                        <td>{{ $perkaras->firstItem() + $loop->index }}</td>
                        <td>{{ $perkara->nomor_perkara }}</td>
                        <td>{{ $perkara->nama_terdakwa }}</td>
                        <td>{{ $perkara->jaksa ?: '-' }}</td>
                        <td>
                            <span class="badge {{ $perkara->kategori === 'narkotika' ? 'bg-danger-subtle text-danger-emphasis' : 'bg-secondary-subtle text-secondary-emphasis' }}">
                                {{ \App\Models\Perkara::KATEGORI[$perkara->kategori] ?? $perkara->kategori }}
                            </span>
                        </td>
                        <td>{{ \App\Models\Perkara::STATUS[$perkara->status] ?? $perkara->status }}</td>
                        <td class="text-center">{{ $perkara->barang_buktis_count }}</td>
                        <td class="text-center">
                            <a href="{{ route('perkara.edit', $perkara) }}" class="btn btn-oren btn-sm">Ubah</a>
                            <form method="POST" action="{{ route('perkara.destroy', $perkara) }}" class="d-inline"
                                  onsubmit="return confirm('Hapus perkara {{ $perkara->nomor_perkara }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada data perkara.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $perkaras->links() }}
@endsection