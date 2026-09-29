<div class="mb-3">
    <label for="nomor_perkara" class="form-label">Nomor perkara</label>
    <input type="text" name="nomor_perkara" id="nomor_perkara"
           class="form-control @error('nomor_perkara') is-invalid @enderror"
           value="{{ old('nomor_perkara', $perkara->nomor_perkara ?? '') }}" placeholder="Contoh: 123/Pid.Sus/2026/PN Bdg">
    @error('nomor_perkara')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="nama_terdakwa" class="form-label">Nama terdakwa</label>
    <input type="text" name="nama_terdakwa" id="nama_terdakwa"
           class="form-control @error('nama_terdakwa') is-invalid @enderror"
           value="{{ old('nama_terdakwa', $perkara->nama_terdakwa ?? '') }}">
    @error('nama_terdakwa')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="jaksa" class="form-label">Jaksa</label>
    <input type="text" name="jaksa" id="jaksa"
           class="form-control @error('jaksa') is-invalid @enderror"
           value="{{ old('jaksa', $perkara->jaksa ?? '') }}">
    @error('jaksa')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="kategori" class="form-label">Kategori</label>
        <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror">
            <option value="">Pilih kategori</option>
            @foreach (\App\Models\Perkara::KATEGORI as $key => $label)
                <option value="{{ $key }}" @selected(old('kategori', $perkara->kategori ?? '') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('kategori')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
            @foreach (\App\Models\Perkara::STATUS as $key => $label)
                <option value="{{ $key }}" @selected(old('status', $perkara->status ?? 'proses') === $key)>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex gap-2">
    <button class="btn btn-oren">Simpan</button>
    <a href="{{ route('perkara.index') }}" class="btn btn-outline-secondary">Batal</a>
</div>