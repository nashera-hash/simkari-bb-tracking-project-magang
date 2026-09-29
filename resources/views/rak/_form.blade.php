<div class="mb-3">
    <label for="gudang_id" class="form-label">Gudang</label>
    <select name="gudang_id" id="gudang_id" class="form-select @error('gudang_id') is-invalid @enderror">
        <option value="">Pilih gudang</option>
        @foreach ($gudangs as $g)
            <option value="{{ $g->id }}" @selected(old('gudang_id', $rak->gudang_id ?? '') == $g->id)>{{ $g->nama }}</option>
        @endforeach
    </select>
    @error('gudang_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="kode" class="form-label">Kode rak</label>
    <input type="text" name="kode" id="kode"
           class="form-control @error('kode') is-invalid @enderror"
           value="{{ old('kode', $rak->kode ?? '') }}" placeholder="Contoh: A1">
    @error('kode')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button class="btn btn-oren">Simpan</button>
    <a href="{{ route('rak.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>