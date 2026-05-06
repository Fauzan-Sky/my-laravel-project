@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')
<div class="laporan-container">

    {{-- HEADER --}}
    <div class="laporan-header">
        <h2>Laporan Pesanan</h2>
        <p>Periode: <strong>{{ $start->format('d M Y') }} – {{ $end->format('d M Y') }}</strong></p>
    </div>

    {{-- FILTER PERIODE --}}
    <form method="GET" action="{{ route('admin.laporan') }}" class="filter-form">
        <div class="filter-group">
            <label>Filter Periode</label>
            <div class="filter-buttons">
                <a href="{{ route('admin.laporan', ['periode' => 'hari']) }}"
                   class="btn-filter {{ $periode == 'hari' ? 'active' : '' }}">Hari Ini</a>
                <a href="{{ route('admin.laporan', ['periode' => 'minggu']) }}"
                   class="btn-filter {{ $periode == 'minggu' ? 'active' : '' }}">Minggu Ini</a>
                <a href="{{ route('admin.laporan', ['periode' => 'bulan']) }}"
                   class="btn-filter {{ $periode == 'bulan' ? 'active' : '' }}">Bulan Ini</a>
                <span class="btn-filter {{ $periode == 'custom' ? 'active' : '' }}"
                      onclick="toggleCustom()">Custom</span>
            </div>
        </div>

        {{-- Custom date range --}}
        <div class="custom-range {{ $periode == 'custom' ? '' : 'd-none' }}" id="customRange">
            <input type="hidden" name="periode" value="custom">
            <input type="date" name="tanggal_mulai"
                   value="{{ request('tanggal_mulai') }}" class="input-date">
            <span>s/d</span>
            <input type="date" name="tanggal_selesai"
                   value="{{ request('tanggal_selesai') }}" class="input-date">
            <button type="submit" class="btn-cari">Tampilkan</button>
        </div>
    </form>

    {{-- SUMMARY CARDS --}}
    <div class="summary-grid">

        {{-- Total Pesanan --}}
        <div class="summary-card blue">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                    <line x1="3" y1="6" x2="21" y2="6"/>
                    <path d="M16 10a4 4 0 01-8 0"/>
                </svg>
            </div>
            <div class="card-info">
                <span class="card-label">Total Pesanan</span>
                <span class="card-value">{{ $totalPesanan }}</span>
            </div>
        </div>

        {{-- Total Pendapatan --}}
        <div class="summary-card green">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                </svg>
            </div>
            <div class="card-info">
                <span class="card-label">Total Pendapatan</span>
                <span class="card-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Pesanan Selesai --}}
        <div class="summary-card teal">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
            <div class="card-info">
                <span class="card-label">Pesanan Selesai</span>
                <span class="card-value">{{ $pesananSelesai }}</span>
            </div>
        </div>

        {{-- Pesanan Aktif --}}
        <div class="summary-card orange">
            <div class="card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div class="card-info">
                <span class="card-label">Pesanan Aktif</span>
                <span class="card-value">{{ $pesananPending }}</span>
            </div>
        </div>

    </div>

    {{-- MENU TERLARIS --}}
    @if($menuTerlaris->count())
    <div class="section-card">
        <h3>Menu Terlaris</h3>
        <table class="laporan-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Menu</th>
                    <th>Total Terjual</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menuTerlaris as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->menu->nama_menu ?? '-' }}</td>
                    <td>{{ $item->total_terjual }} porsi</td>
                    <td>Rp {{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    {{-- TABEL PESANAN --}}
    <div class="section-card">
        <h3>Detail Pesanan</h3>
        @if($orders->count())
        <table class="laporan-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Siswa</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $i => $order)
                @php
                    $statusClass = match($order->status) {
                        'selesai'    => 'status-selesai',
                        'diproses'   => 'status-diproses',
                        'siap'       => 'status-siap',
                        'dibatalkan' => 'status-batal',
                        default      => 'status-pending',
                    };
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td><span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span></td>
                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <p>Tidak ada pesanan pada periode ini.</p>
        </div>
    </div>
    @endif
    </div>

</div>

{{-- CSS --}}
<style>
.laporan-container { padding: 24px; max-width: 1100px; margin: 0 auto; }

/* Header */
.laporan-header { margin-bottom: 20px; }
.laporan-header h2 { font-size: 1.6rem; font-weight: 700; color: #1a1a2e; }
.laporan-header p { color: #666; margin-top: 4px; }

/* Filter */
.filter-form { margin-bottom: 24px; }
.filter-group label { font-size: 0.85rem; font-weight: 600; color: #555; display: block; margin-bottom: 8px; }
.filter-buttons { display: flex; gap: 8px; flex-wrap: wrap; }
.btn-filter {
    padding: 8px 18px; border-radius: 20px; border: 2px solid #0d9488;
    color: #0d9488; font-size: 0.85rem; font-weight: 600;
    cursor: pointer; text-decoration: none; transition: all 0.2s;
}
.btn-filter.active, .btn-filter:hover { background: #0d9488; color: white; }
.custom-range {
    display: flex; align-items: center; gap: 10px;
    margin-top: 12px; flex-wrap: wrap;
}
.custom-range.d-none { display: none; }
.input-date { padding: 8px 12px; border: 1.5px solid #ccc; border-radius: 8px; font-size: 0.9rem; }
.btn-cari {
    padding: 8px 18px; background: #0d9488; color: white;
    border: none; border-radius: 8px; cursor: pointer; font-weight: 600;
}

/* Summary Cards */
.summary-grid {
    display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 16px; margin-bottom: 28px;
}
.summary-card {
    display: flex; align-items: center; gap: 16px;
    padding: 20px; border-radius: 14px; color: white;
}
.summary-card.blue   { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.summary-card.green  { background: linear-gradient(135deg, #22c55e, #15803d); }
.summary-card.teal   { background: linear-gradient(135deg, #14b8a6, #0d9488); }
.summary-card.orange { background: linear-gradient(135deg, #f97316, #c2410c); }
.card-icon {
    width: 48px; height: 48px; flex-shrink: 0;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
}
.card-icon svg { width: 24px; height: 24px; stroke: white; }
.card-label { font-size: 0.8rem; opacity: 0.9; display: block; }
.card-value { font-size: 1.4rem; font-weight: 700; display: block; margin-top: 2px; }

/* Section Card */
.section-card {
    background: white; border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    padding: 24px; margin-bottom: 24px;
}
.section-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 16px; color: #1a1a2e; }

/* Table */
.laporan-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
.laporan-table th {
    background: #f1f5f9; padding: 10px 14px;
    text-align: left; font-weight: 600; color: #475569;
}
.laporan-table td { padding: 10px 14px; border-bottom: 1px solid #f1f5f9; color: #334155; }
.laporan-table tr:last-child td { border-bottom: none; }
.laporan-table tr:hover td { background: #f8fafc; }

/* Status Badge */
.status-badge { padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 600; }
.status-selesai  { background: #dcfce7; color: #15803d; }
.status-diproses { background: #dbeafe; color: #1d4ed8; }
.status-siap     { background: #fef9c3; color: #854d0e; }
.status-batal    { background: #fee2e2; color: #dc2626; }
.status-pending  { background: #f1f5f9; color: #64748b; }

/* Empty state */
.empty-state { text-align: center; padding: 40px; color: #94a3b8; }
.empty-state svg { width: 48px; height: 48px; stroke: #cbd5e1; margin: 0 auto 12px; display: block; }
.empty-state p { font-size: 0.95rem; }
</style>

{{-- JS --}}
<script>
function toggleCustom() {
    const el = document.getElementById('customRange');
    el.classList.toggle('d-none');
}
</script>
@endsection