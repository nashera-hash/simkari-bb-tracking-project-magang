<div class="mb-3">
    <label for="nama" class="form-label">Nama gudang</label>
    <input type="text" name="nama" id="nama"
           class="form-control @error('nama') is-invalid @enderror"
           value="{{ old('nama', $gudang->nama ?? '') }}" placeholder="Contoh: Gudang A">
    @error('nama')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="keterangan" class="form-label">Keterangan</label>
    <input type="text" name="keterangan" id="keterangan"
           class="form-control @error('keterangan') is-invalid @enderror"
           value="{{ old('keterangan', $gudang->keterangan ?? '') }}" placeholder="Contoh: Lantai 1, dekat pintu utama">
    @error('keterangan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="d-flex gap-2">
    <button class="btn btn-oren">Simpan</button>
    <a href="{{ route('gudang.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>