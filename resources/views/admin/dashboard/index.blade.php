@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div style="padding: 0.5rem 0;">

    {{-- Page Header --}}
    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-size: 20px; font-weight: 600; color: #0f4c5c; margin: 0;">Dashboard</h4>
        <p style="font-size: 13px; color: #6b7280; margin: 4px 0 0;">Ringkasan data keseluruhan sistem</p>
    </div>

    {{-- Stats Cards Utama --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; padding:1.25rem;">
                <p style="font-size:12px; color:#6b7280; margin:0 0 6px; text-transform:uppercase; letter-spacing:0.05em;">Total Menu</p>
                <p style="font-size:28px; font-weight:700; color:#0f4c5c; margin:0;">{{ $stats['total_menu'] }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; padding:1.25rem;">
                <p style="font-size:12px; color:#6b7280; margin:0 0 6px; text-transform:uppercase; letter-spacing:0.05em;">Total Order</p>
                <p style="font-size:28px; font-weight:700; color:#0f4c5c; margin:0;">{{ $stats['total_order'] }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; padding:1.25rem;">
                <p style="font-size:12px; color:#6b7280; margin:0 0 6px; text-transform:uppercase; letter-spacing:0.05em;">Total User</p>
                <p style="font-size:28px; font-weight:700; color:#0f4c5c; margin:0;">{{ $stats['total_user'] }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; padding:1.25rem;">
                <p style="font-size:12px; color:#6b7280; margin:0 0 6px; text-transform:uppercase; letter-spacing:0.05em;">Total Revenue</p>
                <p style="font-size:22px; font-weight:700; color:#0f4c5c; margin:0;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Stats Hari Ini --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; border-left:4px solid #1d9e75; padding:1rem 1.25rem;">
                <p style="font-size:12px; color:#6b7280; margin:0 0 6px;">Order Hari Ini</p>
                <p style="font-size:28px; font-weight:700; color:#0f4c5c; margin:0;">{{ $stats['order_hari_ini'] }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; border-left:4px solid #1e6fa8; padding:1rem 1.25rem;">
                <p style="font-size:12px; color:#6b7280; margin:0 0 6px;">Revenue Hari Ini</p>
                <p style="font-size:22px; font-weight:700; color:#0f4c5c; margin:0;">Rp {{ number_format($stats['revenue_hari_ini'], 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; border-left:4px solid #d97706; padding:1rem 1.25rem;">
                <p style="font-size:12px; color:#6b7280; margin:0 0 6px;">Order Pending</p>
                <p style="font-size:28px; font-weight:700; color:#0f4c5c; margin:0;">{{ $stats['order_pending'] }}</p>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div style="background:#fff; border-radius:12px; border:0.5px solid #e2e8f0; overflow:hidden;">
        <div style="padding:1rem 1.25rem; border-bottom:0.5px solid #e2e8f0;">
            <h6 style="font-size:15px; font-weight:600; color:#0f4c5c; margin:0;">Order Terbaru</h6>
        </div>
        <table class="table table-hover mb-0">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">#</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">User</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Status</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Total</th>
                    <th style="font-size:12px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em; border-bottom:0.5px solid #e2e8f0; padding:10px 16px;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent_orders as $order)
                <tr style="border-bottom:0.5px solid #f1f5f9;">
                    <td style="padding:12px 16px; font-size:14px; color:#374151;">{{ $order->id }}</td>
                    <td style="padding:12px 16px; font-size:14px; font-weight:500; color:#0f4c5c;">{{ $order->user->nama_lengkap ?? '-' }}</td>
                    <td style="padding:12px 16px;">
                        <span style="display:inline-block; font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px;
                            @if($order->status == 'selesai') background:#dcfce7; color:#166534;
                            @elseif($order->status == 'pending') background:#fef9c3; color:#854d0e;
                            @elseif($order->status == 'diproses') background:#dbeafe; color:#1e40af;
                            @elseif($order->status == 'dibatalkan') background:#fee2e2; color:#991b1b;
                            @else background:#f1f5f9; color:#475569; @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="padding:12px 16px; font-size:14px; font-weight:500; color:#374151;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td style="padding:12px 16px; font-size:13px; color:#6b7280;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:2rem; color:#9ca3af; font-size:14px;">Belum ada order</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection