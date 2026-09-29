@extends('layouts.app')

@section('title', 'Ubah Barang Bukti')

@section('tabs')
    <a href="{{ route('barang-bukti.index') }}">Data Barang Bukti</a>
    <a href="{{ route('barang-bukti.edit', $barang) }}" class="active">Ubah Barang Bukti</a>
@endsection

@section('content')
    <h1>Ubah Barang Bukti</h1>

    <div class="card-box" style="max-width:720px">
        <form method="POST" action="{{ route('barang-bukti.update', $barang) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Perkara</label>
                <select name="perkara_id" class="form-select @error('perkara_id') is-invalid @enderror">
                    @foreach ($perkaras as $p)
                        <option value="{{ $p->id }}" @selected(old('perkara_id', $barang->perkara_id) == $p->id)>
                            {{ $p->nomor_perkara }} - {{ $p->nama_terdakwa }}
                        </option>
                    @endforeach
                </select>
                @error('perkara_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kode barang</label>
                <input type="text" class="form-control" value="{{ $barang->kode }}" disabled>
                <div class="form-text">Kode tidak bisa diubah.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama barang</label>
                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                       value="{{ old('nama_barang', $barang->nama_barang) }}">
                @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" min="1" class="form-control @error('jumlah') is-invalid @enderror"
                           value="{{ old('jumlah', $barang->jumlah) }}">
                    @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan', $barang->satuan) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kondisi</label>
                    <input type="text" name="kondisi" class="form-control" value="{{ old('kondisi', $barang->kondisi) }}">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-oren">Simpan</button>
                <a href="{{ route('barang-bukti.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection