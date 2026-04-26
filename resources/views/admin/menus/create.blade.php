@extends('layouts.admin')

@section('title', 'Tambah Menu')

@section('content')
<div class="card" style="max-width:600px">
    <div class="card-header"><h5 class="mb-0">Tambah Menu Baru</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                <input type="text" name="nama_menu" class="form-control @error('nama_menu') is-invalid @enderror"
                       value="{{ old('nama_menu') }}">
                @error('nama_menu')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col">
                    <label class="form-label">Harga <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                               value="{{ old('harga') }}">
                    </div>
                    @error('harga')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="col">
                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                           value="{{ old('stok') }}">
                    @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="kategori" class="form-select @error('kategori') is-invalid @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="makanan" {{ old('kategori') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ old('kategori') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack"   {{ old('kategori') == 'snack'   ? 'selected' : '' }}>Snack</option>
                </select>
                @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Menu</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_available" id="is_available" checked>
                    <label class="form-check-label" for="is_available">Tersedia / Aktif</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection