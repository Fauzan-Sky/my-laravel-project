@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . str_pad($order->nomor_antrean, 3, '0', STR_PAD_LEFT))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detail Pesanan #{{ str_pad($order->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- Info Pesanan --}}
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-dark text-white">Info Pesanan</div>
                <div class="card-body">
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
                    <p><strong>No. Antrean:</strong> #{{ str_pad($order->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Siswa:</strong> {{ $order->user->nama_lengkap ?? $order->user->name ?? '-' }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
                    <p><strong>Kantin:</strong> {{ $order->kantin->nama_kantinn ?? '-' }}</p>
                    <p><strong>Slot:</strong> {{ $order->slot->label_slot ?? '-' }}
                        @if($order->slot)
                            <span class="text-muted small">
                                ({{ \Carbon\Carbon::parse($order->slot->jam_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($order->slot->jam_selesai)->format('H:i') }})
                            </span>
                        @endif
                    </p>
                    <p><strong>Catatan:</strong> {{ $order->catatan ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                    <p><strong>Total:</strong> <span class="fw-bold text-success">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></p>
                    <p><strong>Status:</strong> <span class="badge bg-{{ $badge }}">{{ $label }}</span></p>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="card shadow">
                <div class="card-header bg-dark text-white">Update Status</div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Status Baru</label>
                            <select name="status" class="form-select">
                                <option value="pending"    {{ $order->status == 'pending'    ? 'selected' : '' }}>Menunggu</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="ready"      {{ $order->status == 'ready'      ? 'selected' : '' }}>Siap Ambil</option>
                                <option value="picked"     {{ $order->status == 'picked'     ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled"  {{ $order->status == 'cancelled'  ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan Status</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Detail Item --}}
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">Item Pesanan</div>
                <div class="card-body">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Menu</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->detail as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->menu->nama_menu ?? '-' }}</td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada item.</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="table-dark">
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection