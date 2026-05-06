@extends('layouts.admin')

@section('title', 'Kelola Menu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Kelola Menu</h4>
    <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Menu
    </a>
</div>

{{-- Filter & Search --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-center">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama menu..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="makanan" {{ request('kategori') == 'makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="minuman" {{ request('kategori') == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack"   {{ request('kategori') == 'snack'   ? 'selected' : '' }}>Snack</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-secondary" type="submit">Filter</button>
                <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Tabel --}}
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Foto</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                <tr>
                    <td>
                        @if($menu->foto)
                            <img src="{{ asset('storage/' . $menu->foto) }}" width="50" height="50" class="rounded object-fit-cover">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:50px;height:50px">
                                <i class="bi bi-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $menu->nama_menu }}</strong>
                        @if($menu->deskripsi)
                            <br><small class="text-muted">{{ Str::limit($menu->deskripsi, 40) }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $menu->kategori == 'makanan' ? 'bg-warning text-dark' : ($menu->kategori == 'minuman' ? 'bg-info text-dark' : 'bg-secondary') }}">
                            {{ ucfirst($menu->kategori) }}
                        </span>
                    </td>
                    <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $menu->stok > 5 ? 'bg-success' : ($menu->stok > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ $menu->stok }} pcs
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $menu->is_available ? 'bg-success' : 'bg-secondary' }}">
                            {{ $menu->is_available ? 'Tersedia' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.menus.edit', $menu) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus menu ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada menu</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($menus->hasPages())
    <div class="card-footer">
        {{ $menus->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection