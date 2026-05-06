<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual – KantinKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:        #1B6B7B;
            --teal-dark:   #155d6c;
            --teal-light:  #e8f4f6;
            --yellow:      #FFE566;
            --yellow-dark: #f5d800;
            --danger:      #e74c3c;
            --warning:     #f39c12;
            --success:     #27ae60;
            --text:        #1a1a1a;
            --muted:       #888;
            --border:      #e8e8e8;
            --bg:          #f4f7f8;
            --white:       #ffffff;
            --sidebar-w:   260px;
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body { font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; display:flex; }

        .sidebar { width:var(--sidebar-w); background:var(--teal); min-height:100vh; display:flex; flex-direction:column; position:fixed; top:0; left:0; z-index:100; }
        .sidebar-brand { padding:28px 24px 20px; border-bottom:1px solid rgba(255,255,255,0.1); }
        .sidebar-brand .brand-name { font-size:22px; font-weight:800; color:var(--yellow); }
        .sidebar-brand .brand-sub  { font-size:12px; color:rgba(255,255,255,0.5); margin-top:2px; }

        .sidebar-kantin { padding:16px 24px; background:rgba(0,0,0,0.15); border-bottom:1px solid rgba(255,255,255,0.1); }
        .sidebar-kantin .kantin-label { font-size:10px; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:1px; margin-bottom:4px; }
        .sidebar-kantin .kantin-name  { font-size:14px; font-weight:600; color:#fff; }

        .kantin-status-buka {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #6EE7B7;
            margin-top: 4px;
        }
        .kantin-status-buka::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #6EE7B7;
            animation: pulse 2s infinite;
        }
        .kantin-status-tutup {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            color: #fca5a5;
            margin-top: 4px;
        }

        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

        .sidebar-nav { flex:1; padding:16px 0; }
        .nav-section-label { font-size:10px; font-weight:600; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:1.2px; padding:12px 24px 6px; }

        .nav-item { display:flex; align-items:center; gap:12px; padding:11px 24px; color:rgba(255,255,255,0.65); font-size:14px; font-weight:500; cursor:pointer; transition:all 0.2s; border-left:3px solid transparent; text-decoration:none; }
        .nav-item:hover { background:rgba(255,255,255,0.07); color:#fff; }
        .nav-item.active { background:rgba(255,255,255,0.12); color:#fff; border-left-color:var(--yellow); font-weight:600; }
        .nav-item .nav-icon { width:22px; display:flex; align-items:center; justify-content:center; }
        .nav-item .nav-icon svg { stroke:rgba(255,255,255,0.65); transition:stroke 0.2s; }
        .nav-item:hover .nav-icon svg, .nav-item.active .nav-icon svg { stroke:#fff; }

        .sidebar-footer { padding:16px 24px; border-top:1px solid rgba(255,255,255,0.1); }
        .penjual-info { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
        .penjual-avatar { width:36px; height:36px; background:var(--yellow); border-radius:50%; display:flex; align-items:center; justify-content:center; }
        .penjual-avatar svg { stroke:var(--teal-dark); }
        .penjual-detail .penjual-name { font-size:13px; font-weight:600; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:160px; }
        .penjual-detail .penjual-role { font-size:11px; color:rgba(255,255,255,0.45); }

        .btn-logout { width:100%; padding:10px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:10px; color:rgba(255,255,255,0.7); font-family:'Poppins',sans-serif; font-size:13px; font-weight:500; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px; }
        .btn-logout:hover { background:rgba(231,76,60,0.25); border-color:rgba(231,76,60,0.4); color:#ff8a8a; }

        .main { margin-left:var(--sidebar-w); flex:1; padding:32px; }
        .page-header { margin-bottom:28px; }
        .page-title    { font-size:22px; font-weight:800; color:var(--text); }
        .page-subtitle { font-size:13px; color:var(--muted); margin-top:2px; }

        /* Banner kantin tutup */
        .banner-tutup {
            background: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .banner-tutup .bt-title { font-size:13px; font-weight:700; color:#b91c1c; }
        .banner-tutup .bt-sub   { font-size:12px; color:#ef4444; margin-top:2px; }

        .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:28px; }
        .stat-card { background:var(--white); border-radius:16px; padding:20px; display:flex; align-items:center; gap:16px; box-shadow:0 2px 12px rgba(0,0,0,0.05); transition:transform 0.2s,box-shadow 0.2s; }
        .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.09); }
        .stat-icon { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .stat-icon.teal   { background:var(--teal-light); } .stat-icon.teal svg   { stroke:var(--teal); }
        .stat-icon.yellow { background:#fff8e1; }           .stat-icon.yellow svg { stroke:#d4a017; }
        .stat-icon.red    { background:#fef0ee; }           .stat-icon.red svg    { stroke:var(--danger); }
        .stat-icon.green  { background:#eafaf1; }           .stat-icon.green svg  { stroke:var(--success); }
        .stat-info .stat-label { font-size:12px; color:var(--muted); font-weight:500; }
        .stat-info .stat-value { font-size:22px; font-weight:800; color:var(--text); line-height:1.2; margin-top:2px; }
        .stat-info .stat-sub   { font-size:11px; color:var(--muted); margin-top:2px; }

        .section-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
        .section-full { margin-bottom:20px; }

        .card { background:var(--white); border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.05); overflow:hidden; }
        .card-header { padding:18px 22px 14px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid var(--border); }
        .card-title  { font-size:15px; font-weight:700; color:var(--text); }
        .card-body   { padding:20px 22px; }

        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        thead th { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; color:var(--muted); padding:10px 14px; background:#fafafa; text-align:left; border-bottom:1px solid var(--border); }
        tbody td { padding:13px 14px; font-size:13px; color:var(--text); border-bottom:1px solid #f0f0f0; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover { background:#fafcfc; }

        .badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:100px; font-size:11px; font-weight:600; }
        .badge-pending    { background:#fff3cd; color:#856404; }
        .badge-processing { background:#cce5ff; color:#004085; }
        .badge-ready      { background:#d4edda; color:#155724; }
        .badge-picked     { background:#e2e3e5; color:#383d41; }
        .badge-tunai      { background:#e8f4f6; color:#1B6B7B; }

        tr.row-pending { background:#fffbf0 !important; border-left:3px solid #f39c12; }
        tr.row-pending:hover { background:#fff8e6 !important; }
        .new-order-dot { display:inline-block; width:8px; height:8px; background:#e74c3c; border-radius:50%; margin-right:6px; animation:pulse 1.5s infinite; }

        .select-status { padding:5px 10px; border:1.5px solid var(--border); border-radius:8px; font-family:'Poppins',sans-serif; font-size:12px; font-weight:500; color:var(--text); background:var(--white); cursor:pointer; outline:none; transition:border-color 0.2s; }
        .select-status:focus { border-color:var(--teal); }
        .select-status:disabled { opacity:0.5; cursor:not-allowed; }

        .stok-value { font-weight:700; font-size:14px; }
        .stok-low  { color:var(--danger); }
        .stok-mid  { color:var(--warning); }
        .stok-high { color:var(--success); }

        .stok-input { width:70px; padding:5px 8px; border:1.5px solid var(--border); border-radius:8px; font-family:'Poppins',sans-serif; font-size:13px; text-align:center; outline:none; transition:border-color 0.2s; }
        .stok-input:focus { border-color:var(--teal); }

        .btn { padding:7px 14px; border-radius:8px; font-family:'Poppins',sans-serif; font-size:12px; font-weight:600; cursor:pointer; border:none; transition:all 0.2s; }
        .btn-teal { background:var(--teal); color:#fff; }
        .btn-teal:hover { background:var(--teal-dark); }
        .btn-sm { padding:5px 12px; font-size:12px; }
        .btn-outline { background:transparent; border:1.5px solid var(--border); color:var(--muted); }
        .btn-outline:hover { border-color:var(--teal); color:var(--teal); }

        .toggle-switch { position:relative; width:40px; height:22px; }
        .toggle-switch input { display:none; }
        .toggle-slider { position:absolute; top:0; left:0; right:0; bottom:0; background:#ccc; border-radius:22px; cursor:pointer; transition:0.3s; }
        .toggle-slider::before { content:''; position:absolute; width:16px; height:16px; left:3px; top:3px; background:#fff; border-radius:50%; transition:0.3s; }
        .toggle-switch input:checked + .toggle-slider { background:var(--teal); }
        .toggle-switch input:checked + .toggle-slider::before { transform:translateX(18px); }

        .alert { padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:20px; font-weight:500; transition:opacity 0.6s ease; }
        .alert-success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
        .alert-danger  { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }

        .empty-state { text-align:center; padding:40px 20px; color:var(--muted); }
        .empty-state .empty-icon { margin-bottom:10px; display:flex; justify-content:center; }
        .empty-state p { font-size:14px; }

        .tab-bar { display:flex; gap:4px; background:#f0f0f0; border-radius:10px; padding:4px; margin-bottom:20px; width:fit-content; }
        .tab-btn { padding:8px 18px; border-radius:8px; border:none; background:transparent; font-family:'Poppins',sans-serif; font-size:13px; font-weight:500; color:var(--muted); cursor:pointer; transition:all 0.2s; }
        .tab-btn.active { background:var(--white); color:var(--teal); font-weight:700; box-shadow:0 1px 4px rgba(0,0,0,0.08); }

        .antrean-badge { background:var(--teal); color:#fff; font-weight:800; font-size:13px; padding:4px 10px; border-radius:8px; display:inline-block; }

        @media (max-width:1100px) { .stat-grid{grid-template-columns:repeat(2,1fr)} .section-grid{grid-template-columns:1fr} }
        @media (max-width:768px)  { .sidebar{transform:translateX(-100%)} .main{margin-left:0; padding:20px 16px} .stat-grid{grid-template-columns:1fr 1fr} }
    </style>
</head>
<body>

@php
    $kantinPenjual = auth('penjual')->user()->kantin;
    $isKantinBuka  = $kantinPenjual && $kantinPenjual->status_operasional === 'buka';
@endphp

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">KantinKu</div>
        <div class="brand-sub">Panel Penjual</div>
    </div>

    <div class="sidebar-kantin">
        <div class="kantin-label">Kantin Aktif</div>
        <div class="kantin-name">{{ $kantinPenjual->nama_kantinn ?? 'Kantin Saya' }}</div>
        @if($isKantinBuka)
            <div class="kantin-status-buka">Sedang Buka</div>
        @else
            <div class="kantin-status-tutup">⛔ Sedang Tutup</div>
        @endif
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Menu</div>
        <a href="#dashboard" class="nav-item active" onclick="showPage('dashboard')">
            <span class="nav-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg></span> Dashboard
        </a>
        <a href="#pesanan" class="nav-item" onclick="showPage('pesanan')">
            <span class="nav-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg></span> Daftar Pesanan
        </a>
        <a href="#stok" class="nav-item" onclick="showPage('stok')">
            <span class="nav-icon"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg></span> Manajemen Stok
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="penjual-info">
            <div class="penjual-avatar"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
            <div class="penjual-detail">
                <div class="penjual-name">{{ auth('penjual')->user()->nama }}</div>
                <div class="penjual-role">Penjual</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<main class="main">

    @if(session('success'))
        <div id="flash-message" class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div id="flash-message" class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Banner peringatan kantin tutup --}}
    @if(!$isKantinBuka)
    <div class="banner-tutup">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#e74c3c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <div>
            <div class="bt-title">Kantin Sedang Ditutup oleh Admin</div>
            <div class="bt-sub">Pesanan baru tidak bisa diproses. Hubungi admin untuk membuka kantin kembali.</div>
        </div>
    </div>
    @endif

    {{-- PAGE: DASHBOARD --}}
    <div id="page-dashboard">
        <div class="page-header">
            <div class="page-title">Selamat datang, {{ auth('penjual')->user()->nama }}</div>
            <div class="page-subtitle">{{ now()->translatedFormat('l, d F Y') }}</div>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-icon teal"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg></div>
                <div class="stat-info">
                    <div class="stat-label">Total Pesanan Hari Ini</div>
                    <div class="stat-value">{{ $totalPesananHariIni ?? 0 }}</div>
                    <div class="stat-sub">pesanan masuk</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
                <div class="stat-info">
                    <div class="stat-label">Pendapatan Harian</div>
                    <div class="stat-value">Rp {{ number_format($pendapatanHarian ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-sub">hari ini</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                <div class="stat-info">
                    <div class="stat-label">Pesanan Menunggu</div>
                    <div class="stat-value">{{ $pesananMenunggu ?? 0 }}</div>
                    <div class="stat-sub">perlu diproses</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 15.01 9 12.01"/></svg></div>
                <div class="stat-info">
                    <div class="stat-label">Pesanan Selesai</div>
                    <div class="stat-value">{{ $pesananSelesai ?? 0 }}</div>
                    <div class="stat-sub">sudah diambil</div>
                </div>
            </div>
        </div>

        <div class="section-grid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Pesanan Terbaru</div>
                    <button class="btn btn-outline btn-sm" onclick="showPage('pesanan')">Lihat Semua</button>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Antrean</th><th>Pembeli</th><th>Total</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($pesananTerbaru ?? [] as $p)
                            <tr>
                                <td><span class="antrean-badge">#{{ str_pad($p->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</span></td>
                                <td>{{ $p->user->nama_lengkap ?? '-' }}</td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $bc = match($p->status) { 'pending'=>'badge-pending','processing'=>'badge-processing','ready'=>'badge-ready','picked'=>'badge-picked',default=>'badge-pending' };
                                        $bl = match($p->status) { 'pending'=>'Menunggu','processing'=>'Diproses','ready'=>'Siap','picked'=>'Diambil',default=>$p->status };
                                    @endphp
                                    <span class="badge {{ $bc }}">{{ $bl }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4"><div class="empty-state"><div class="empty-icon" style="color:#ccc"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg></div><p>Belum ada pesanan hari ini</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="display:flex;align-items:center;gap:8px"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> Stok Menipis</div>
                    <button class="btn btn-outline btn-sm" onclick="showPage('stok')">Kelola Stok</button>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Menu</th><th>Stok</th><th>Status</th></tr></thead>
                        <tbody>
                            @forelse($stokMenipis ?? [] as $m)
                            <tr>
                                <td>{{ $m->nama_menu }}</td>
                                <td><span class="stok-value {{ $m->stok <= 5 ? 'stok-low' : 'stok-mid' }}">{{ $m->stok }}</span></td>
                                <td><span class="badge {{ $m->stok <= 5 ? 'badge-pending' : 'badge-processing' }}">{{ $m->stok <= 5 ? 'Kritis' : 'Menipis' }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="3"><div class="empty-state"><div class="empty-icon" style="color:#27ae60"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 15.01 9 12.01"/></svg></div><p>Semua stok aman</p></div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- PAGE: DAFTAR PESANAN --}}
    <div id="page-pesanan" style="display:none">
        <div class="page-header">
            <div class="page-title">Daftar Pesanan</div>
            <div class="page-subtitle">Kelola dan ubah status pesanan masuk</div>
        </div>

        <div class="tab-bar">
            <button class="tab-btn active" onclick="filterStatus('semua', this)">Semua</button>
            <button class="tab-btn" onclick="filterStatus('pending', this)">Menunggu</button>
            <button class="tab-btn" onclick="filterStatus('processing', this)">Diproses</button>
            <button class="tab-btn" onclick="filterStatus('ready', this)">Siap</button>
            <button class="tab-btn" onclick="filterStatus('picked', this)">Diambil</button>
        </div>

        <div class="card section-full">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Antrean</th><th>Pembeli</th><th>Kelas</th><th>Menu</th>
                            <th>Total</th><th>Jadwal</th><th>Bayar</th><th>Waktu</th>
                            <th>Status</th><th>Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($semuaPesanan ?? [] as $p)
                        <tr data-status="{{ $p->status }}" class="{{ $p->status === 'pending' ? 'row-pending' : '' }}">
                            <td>
                                @if($p->status === 'pending')<span class="new-order-dot"></span>@endif
                                <span class="antrean-badge">#{{ str_pad($p->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td><div style="font-weight:600; font-size:13px">{{ $p->user->nama_lengkap ?? '-' }}</div></td>
                            <td style="font-size:12px; color:var(--muted)">{{ $p->user->kelas ?? '-' }}</td>
                            <td style="font-size:12px; max-width:140px">
                                @foreach($p->detailPesanan as $d)
                                    <div>{{ $d->menu->nama_menu ?? '-' }} <span style="color:var(--muted)">x{{ $d->jumlah }}</span></div>
                                @endforeach
                            </td>
                            <td style="font-weight:700">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td style="font-size:12px">
                                @if($p->slotWaktu)
                                    <div style="font-weight:600; color:var(--teal)">{{ $p->slotWaktu->label_slot }}</div>
                                    <div style="color:var(--muted)">{{ \Carbon\Carbon::parse($p->slotWaktu->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($p->slotWaktu->jam_selesai)->format('H:i') }}</div>
                                @else
                                    <span style="color:var(--muted)">-</span>
                                @endif
                            </td>
                            <td><span class="badge badge-tunai">Tunai</span></td>
                            <td style="font-size:12px; color:var(--muted)">{{ $p->created_at->format('H:i') }}</td>
                            <td>
                                @php
                                    $bc = match($p->status) { 'pending'=>'badge-pending','processing'=>'badge-processing','ready'=>'badge-ready','picked'=>'badge-picked',default=>'badge-pending' };
                                    $bl = match($p->status) { 'pending'=>'Menunggu','processing'=>'Diproses','ready'=>'Siap Diambil','picked'=>'Sudah Diambil',default=>$p->status };
                                @endphp
                                <span class="badge {{ $bc }}">{{ $bl }}</span>
                            </td>
                            <td>
                                @if($isKantinBuka)
                                <form method="POST" action="{{ route('penjual.pesanan.updateStatus', $p->id) }}">
                                    @csrf @method('PATCH')
                                    <select name="status" class="select-status" onchange="this.form.submit()">
                                        <option value="pending"    {{ $p->status === 'pending'    ? 'selected' : '' }}>Menunggu</option>
                                        <option value="processing" {{ $p->status === 'processing' ? 'selected' : '' }}>Diproses</option>
                                        <option value="ready"      {{ $p->status === 'ready'      ? 'selected' : '' }}>Siap</option>
                                        <option value="picked"     {{ $p->status === 'picked'     ? 'selected' : '' }}>Diambil</option>
                                    </select>
                                </form>
                                @else
                                <span style="font-size:11px; color:#e74c3c; font-weight:600;">⛔ Kantin Tutup</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10"><div class="empty-state"><div class="empty-icon" style="color:#ccc"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/></svg></div><p>Belum ada pesanan</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PAGE: MANAJEMEN STOK --}}
    <div id="page-stok" style="display:none">
        <div class="page-header">
            <div class="page-title">Manajemen Stok</div>
            <div class="page-subtitle">Kelola stok dan ketersediaan menu</div>
        </div>

        <div class="card section-full">
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Foto</th><th>Nama Menu</th><th>Kategori</th><th>Harga</th><th>Stok Sekarang</th><th>Update Stok</th><th>Tersedia</th></tr></thead>
                    <tbody>
                        @forelse($menuList ?? [] as $menu)
                        <tr>
                            <td>
                                <div style="display:flex; flex-direction:column; align-items:center; gap:8px;">
                                    @if($menu->foto)
                                        <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}" style="width:56px; height:56px; object-fit:cover; border-radius:10px; border:1px solid var(--border);">
                                    @else
                                        <div style="width:56px; height:56px; background:var(--teal-light); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('penjual.stok.uploadFoto', $menu->id) }}" enctype="multipart/form-data" style="display:flex; flex-direction:column; align-items:center; gap:4px;">
                                        @csrf
                                        <input type="file" name="foto" accept="image/*" style="display:none" id="foto-{{ $menu->id }}" onchange="this.form.submit()">
                                        <label for="foto-{{ $menu->id }}" style="font-size:11px; font-weight:600; color:var(--teal); cursor:pointer; padding:3px 8px; border:1px solid var(--teal); border-radius:6px;">
                                            {{ $menu->foto ? 'Ganti' : 'Upload' }}
                                        </label>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:600">{{ $menu->nama_menu }}</div>
                                @if($menu->deskripsi)<div style="font-size:11px; color:var(--muted)">{{ Str::limit($menu->deskripsi, 40) }}</div>@endif
                            </td>
                            <td><span class="badge badge-processing" style="text-transform:capitalize">{{ $menu->kategori ?? '-' }}</span></td>
                            <td style="font-weight:600">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                            <td><span class="stok-value {{ $menu->stok <= 5 ? 'stok-low' : ($menu->stok <= 15 ? 'stok-mid' : 'stok-high') }}">{{ $menu->stok }}</span></td>
                            <td>
                                <form method="POST" action="{{ route('penjual.stok.update', $menu->id) }}" style="display:flex; gap:6px; align-items:center">
                                    @csrf @method('PATCH')
                                    <input type="number" name="stok" class="stok-input" value="{{ $menu->stok }}" min="0" max="999">
                                    <button type="submit" class="btn btn-teal btn-sm">Simpan</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('penjual.stok.toggleAvailable', $menu->id) }}">
                                    @csrf @method('PATCH')
                                    <label class="toggle-switch">
                                        <input type="checkbox" name="is_available" {{ $menu->is_available ? 'checked' : '' }} onchange="this.form.submit()">
                                        <span class="toggle-slider"></span>
                                    </label>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7"><div class="empty-state"><div class="empty-icon" style="color:#ccc"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg></div><p>Belum ada menu.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<script>
    const flashMsg = document.getElementById('flash-message');
    if (flashMsg) {
        setTimeout(() => {
            flashMsg.style.opacity = '0';
            setTimeout(() => flashMsg.remove(), 600);
        }, 3000);
    }

    function showPage(page) {
        ['dashboard','pesanan','stok'].forEach(p => {
            document.getElementById('page-' + p).style.display = p === page ? 'block' : 'none';
        });
        document.querySelectorAll('.nav-item').forEach(el => {
            el.classList.toggle('active', el.getAttribute('href') === '#' + page);
        });
    }

    function filterStatus(status, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('tbody tr[data-status]').forEach(row => {
            row.style.display = (status === 'semua' || row.dataset.status === status) ? '' : 'none';
        });
    }
</script>
</body>
</html>