@extends('layouts.app')

@section('title', 'Tambah Barang Bukti')

@section('tabs')
    <a href="{{ route('barang-bukti.index') }}">Data Barang Bukti</a>
    <a href="{{ route('barang-bukti.create') }}" class="active">Tambah Barang Bukti</a>
@endsection

@section('content')
    <h1>Tambah Barang Bukti</h1>

    <div class="card-box" style="max-width:720px">
        <form method="POST" action="{{ route('barang-bukti.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Perkara</label>
                <select name="perkara_id" class="form-select @error('perkara_id') is-invalid @enderror">
                    <option value="">Pilih perkara</option>
                    @foreach ($perkaras as $p)
                        <option value="{{ $p->id }}" @selected(old('perkara_id') == $p->id)>
                            {{ $p->nomor_perkara }} - {{ $p->nama_terdakwa }}
                        </option>
                    @endforeach
                </select>
                @error('perkara_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kode barang</label>
                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                       value="{{ old('kode') }}" placeholder="Contoh: BB-0001">
                @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Nama barang</label>
                <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
                       value="{{ old('nama_barang') }}">
                @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="jumlah" min="1" class="form-control @error('jumlah') is-invalid @enderror"
                           value="{{ old('jumlah', 1) }}">
                    @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}" placeholder="unit, buah, kg">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kondisi</label>
                    <input type="text" name="kondisi" class="form-control" value="{{ old('kondisi') }}" placeholder="Baik, rusak ringan">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status awal</label>
                <select name="status" class="form-select">
                    @foreach (\App\Models\BarangBukti::STATUS as $key => $label)
                        <option value="{{ $key }}" @selected(old('status', 'disimpan') === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gudang (opsional)</label>
                    <select name="gudang_id" id="gudang_id" class="form-select">
                        <option value="">Belum ditempatkan</option>
                        @foreach ($gudangs as $g)
                            <option value="{{ $g->id }}" @selected(old('gudang_id') == $g->id)>{{ $g->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rak (opsional)</label>
                    <select name="rak_id" id="rak_id" class="form-select">
                        <option value="">Pilih gudang dulu</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-oren">Simpan</button>
                <a href="{{ route('barang-bukti.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>

    <script>
        const gudangs = @json($gudangs->keyBy('id'));
        const gudangSelect = document.getElementById('gudang_id');
        const rakSelect = document.getElementById('rak_id');
        const oldRak = '{{ old('rak_id') }}';

        function isiRak() {
            rakSelect.innerHTML = '<option value="">Tidak ada rak</option>';
            const g = gudangs[gudangSelect.value];
            if (g && g.raks) {
                g.raks.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.id;
                    opt.textContent = r.kode;
                    if (String(r.id) === oldRak) opt.selected = true;
                    rakSelect.appendChild(opt);
                });
            }
        }
        gudangSelect.addEventListener('change', isiRak);
        if (gudangSelect.value) isiRak();
    </script>
@endsection