@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
<div class="card" style="max-width:600px">
    <div class="card-header"><h5 class="mb-0">Edit Menu: {{ $menu->nama_menu }}</h5></div>
    <div class="card-body">
        <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Menu <span class="text-danger">*</span></label>
                <input type="text" name="nama_menu" class="form-control @error('nama_menu') is-invalid @enderror"
                       value="{{ old('nama_menu', $menu->nama_menu) }}">
                @error('nama_menu')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>

            <div class="row g-3 mb-3">
                <div class="col">
                    <label class="form-label">Harga <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" class="form-control"
                               value="{{ old('harga', $menu->harga) }}">
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stok" class="form-control"
                           value="{{ old('stok', $menu->stok) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                <select name="kategori" class="form-select">
                    <option value="makanan" {{ $menu->kategori == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ $menu->kategori == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack"   {{ $menu->kategori == 'snack'   ? 'selected' : '' }}>Snack</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Menu</label>
                @if($menu->foto)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $menu->foto) }}" height="80" class="rounded">
                        <small class="text-muted d-block">Upload baru untuk mengganti foto</small>
                    </div>
                @endif
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_available" id="is_available"
                           {{ $menu->is_available ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_available">Tersedia / Aktif</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection