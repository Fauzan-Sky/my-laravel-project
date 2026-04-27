@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Daftar Pesanan</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-2 align-items-end">
                <div class="col-auto">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">-- Semua --</option>
                        <option value="pending"    {{ request('status') == 'pending'    ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="ready"      {{ request('status') == 'ready'      ? 'selected' : '' }}>Siap Ambil</option>
                        <option value="picked"     {{ request('status') == 'picked'     ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled"  {{ request('status') == 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-auto">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#Antrean</th>
                        <th>Siswa</th>
                        <th>Kantin</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ str_pad($order->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>
                            {{ $order->user->nama_lengkap ?? $order->user->name ?? '-' }}
                            @if($order->user)
                                <div class="text-muted small">{{ $order->user->email }}</div>
                            @endif
                        </td>
                        <td>{{ $order->kantin->nama_kantinn ?? '-' }}</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $badge = [
                                    'pending'    => 'warning',
                                    'processing' => 'info',
                                    'ready'      => 'success',
                                    'picked'     => 'secondary',
                                    'cancelled'  => 'danger',
                                ][$order->status] ?? 'secondary';
                                $label = $order->status_badge['label'] ?? ucfirst($order->status);
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                        </td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="btn btn-sm btn-info text-white">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection