@extends('layouts.app')

@section('title', 'Pindahkan Barang Bukti')

@section('tabs')
    <a href="{{ route('barang-bukti.index') }}">Data Barang Bukti</a>
    <a href="{{ route('barang-bukti.pindah', $barang) }}" class="active">Pindahkan</a>
@endsection

@section('content')
    <h1>Pindahkan {{ $barang->kode }}</h1>

    <div class="card-box" style="max-width:640px">
        <form method="POST" action="{{ route('barang-bukti.pindah', $barang) }}">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Gudang tujuan</label>
                    <select name="gudang_id" id="gudang_id" class="form-select">
                        <option value="">Tidak ditempatkan</option>
                        @foreach ($gudangs as $g)
                            <option value="{{ $g->id }}" @selected(old('gudang_id', $barang->gudang_id) == $g->id)>{{ $g->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rak tujuan</label>
                    <select name="rak_id" id="rak_id" class="form-select">
                        <option value="">Tidak ada rak</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status baru</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    @foreach (\App\Models\BarangBukti::STATUS as $key => $label)
                        <option value="{{ $key }}" @selected(old('status', $barang->status) === $key)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: dipindahkan untuk persidangan">{{ old('keterangan') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-oren">Simpan perpindahan</button>
                <a href="{{ route('barang-bukti.show', $barang) }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>

    <script>
        const gudangs = @json($gudangs->keyBy('id'));
        const gudangSelect = document.getElementById('gudang_id');
        const rakSelect = document.getElementById('rak_id');
        const currentRak = '{{ old('rak_id', $barang->rak_id) }}';

        function isiRak() {
            rakSelect.innerHTML = '<option value="">Tidak ada rak</option>';
            const g = gudangs[gudangSelect.value];
            if (g && g.raks) {
                g.raks.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.id;
                    opt.textContent = r.kode;
                    if (String(r.id) === currentRak) opt.selected = true;
                    rakSelect.appendChild(opt);
                });
            }
        }
        gudangSelect.addEventListener('change', isiRak);
        if (gudangSelect.value) isiRak();
    </script>
@endsection