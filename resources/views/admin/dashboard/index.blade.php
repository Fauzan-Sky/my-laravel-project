@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Dashboard</h4>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total Menu</h6>
                    <h3>{{ $stats['total_menu'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Total Order</h6>
                    <h3>{{ $stats['total_order'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Total User</h6>
                    <h3>{{ $stats['total_user'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Total Revenue</h6>
                    <h3>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Hari Ini --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted">Order Hari Ini</h6>
                    <h4>{{ $stats['order_hari_ini'] }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted">Revenue Hari Ini</h6>
                    <h4>Rp {{ number_format($stats['revenue_hari_ini'], 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Order Pending</h6>
                    <h4>{{ $stats['order_pending'] }}</h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Order Terbaru</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? '-' }}</td>
                        <td>
                            <span class="badge 
                                @if($order->status == 'selesai') bg-success
                                @elseif($order->status == 'pending') bg-warning
                                @elseif($order->status == 'diproses') bg-info
                                @elseif($order->status == 'dibatalkan') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">Belum ada order</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection