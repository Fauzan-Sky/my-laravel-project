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

        /* === MODAL === */
        .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.5); display:none; align-items:center; justify-content:center; z-index:1000; padding:20px; }
        .modal-overlay.show { display:flex; }
        .modal-box { background:#fff; border-radius:16px; width:100%; max-width:520px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3); animation:modalIn 0.2s ease; }
        @keyframes modalIn { from{opacity:0; transform:translateY(-20px);} to{opacity:1; transform:translateY(0);} }
        .modal-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .modal-title { font-size:16px; font-weight:700; color:var(--text); }
        .modal-close { background:none; border:none; font-size:22px; color:var(--muted); cursor:pointer; line-height:1; padding:0 4px; }
        .modal-close:hover { color:var(--danger); }
        .modal-body { padding:20px 24px; }
        .modal-footer { padding:14px 24px; border-top:1px solid var(--border); display:flex; gap:10px; justify-content:flex-end; }

        .form-group { margin-bottom:14px; }
        .form-label { display:block; font-size:12px; font-weight:600; color:var(--text); margin-bottom:6px; }
        .form-label .required { color:var(--danger); }
        .form-control { width:100%; padding:9px 12px; border:1.5px solid var(--border); border-radius:8px; font-family:'Poppins',sans-serif; font-size:13px; outline:none; transition:border-color 0.2s; }
        .form-control:focus { border-color:var(--teal); }
        textarea.form-control { resize:vertical; min-height:70px; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .form-hint { font-size:11px; color:var(--muted); margin-top:4px; }
        .btn-danger { background:var(--danger); color:#fff; }
        .btn-danger:hover { background:#c0392b; }
        .btn-icon { padding:6px 8px; border-radius:6px; background:transparent; border:1px solid var(--border); cursor:pointer; transition:all 0.15s; display:inline-flex; align-items:center; justify-content:center; }
        .btn-icon:hover { background:#f5f5f5; }
        .btn-icon.btn-icon-danger:hover { background:#fef0ee; border-color:var(--danger); }
        .btn-icon.btn-icon-danger:hover svg { stroke:var(--danger); }

        .btn-add-menu { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; background:var(--teal); color:#fff; border:none; border-radius:10px; font-family:'Poppins',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:background 0.2s; }
        .btn-add-menu:hover { background:var(--teal-dark); }
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
                                @if($p->slot)
                                    <div style="font-weight:600; color:var(--teal)">{{ $p->slot->label_slot }}</div>
                                    <div style="color:var(--muted)">{{ \Carbon\Carbon::parse($p->slot->jam_mulai)->format('H:i') }} – {{ \Carbon\Carbon::parse($p->slot->jam_selesai)->format('H:i') }}</div>
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
        <div class="page-header" style="display:flex; align-items:center; justify-content:space-between;">
            <div>
                <div class="page-title">Manajemen Stok</div>
                <div class="page-subtitle">Kelola stok dan ketersediaan menu</div>
            </div>
            <button type="button" class="btn-add-menu" onclick="openModalTambah()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Menu
            </button>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="card section-full">
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Foto</th><th>Nama Menu</th><th>Kategori</th><th>Harga</th><th>Stok Sekarang</th><th>Update Stok</th><th>Tersedia</th><th style="text-align:center">Aksi</th></tr></thead>
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
                            <td style="text-align:center">
                                <div style="display:inline-flex; gap:6px;">
                                    <button type="button" class="btn-icon" title="Edit menu"
                                        @php
                                            $menuData = [
                                                'id'           => $menu->id,
                                                'nama_menu'    => $menu->nama_menu,
                                                'kategori'     => $menu->kategori,
                                                'harga'        => (float) $menu->harga,
                                                'stok'         => (int) $menu->stok,
                                                'deskripsi'    => $menu->deskripsi,
                                                'is_available' => (bool) $menu->is_available,
                                                'foto'         => $menu->foto ? asset('storage/' . $menu->foto) : null,
                                            ];
                                        @endphp
                                        <button type="button" class="btn-icon" title="Edit menu"
                                            onclick="openModalEdit({{ json_encode($menuData, JSON_HEX_APOS | JSON_HEX_QUOT) }})">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button type="button" class="btn-icon btn-icon-danger" title="Hapus menu"
                                        onclick="openModalHapus({{ $menu->id }}, '{{ addslashes($menu->nama_menu) }}')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8"><div class="empty-state"><div class="empty-icon" style="color:#ccc"><svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/></svg></div><p>Belum ada menu. Klik <b>Tambah Menu</b> untuk menambahkan.</p></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

{{-- ===== MODAL: TAMBAH / EDIT MENU ===== --}}
<div id="modal-menu" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title" id="modal-menu-title">Tambah Menu Baru</div>
            <button type="button" class="modal-close" onclick="closeModal('modal-menu')">×</button>
        </div>
        <form id="form-menu" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="modal-method-field"></div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nama Menu <span class="required">*</span></label>
                    <input type="text" name="nama_menu" id="f-nama_menu" class="form-control" required maxlength="100" placeholder="Contoh: Nasi Goreng Spesial">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kategori <span class="required">*</span></label>
                        <select name="kategori" id="f-kategori" class="form-control" required>
                            <option value="">-- Pilih --</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga (Rp) <span class="required">*</span></label>
                        <input type="number" name="harga" id="f-harga" class="form-control" required min="0" max="9999999" step="100" placeholder="5000">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Stok Awal <span class="required">*</span></label>
                    <input type="number" name="stok" id="f-stok" class="form-control" required min="0" max="999" placeholder="0">
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="f-deskripsi" class="form-control" maxlength="500" placeholder="Deskripsi singkat menu..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Foto Menu</label>
                    <div id="f-foto-preview" style="display:none; margin-bottom:8px;">
                        <img id="f-foto-img" src="" alt="" style="width:80px; height:80px; object-fit:cover; border-radius:8px; border:1px solid var(--border);">
                    </div>
                    <input type="file" name="foto" id="f-foto" class="form-control" accept="image/jpeg,image/jpg,image/png,image/webp">
                    <div class="form-hint">JPG, PNG, atau WEBP. Maksimal 2MB. Kosongkan kalau tidak ingin mengubah foto.</div>
                </div>

                <div class="form-group">
                    <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                        <input type="checkbox" name="is_available" id="f-is_available" value="1" checked style="width:16px; height:16px; cursor:pointer;">
                        <span style="font-size:13px; font-weight:500;">Tersedia untuk dipesan</span>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('modal-menu')">Batal</button>
                <button type="submit" class="btn btn-teal" id="modal-menu-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ===== MODAL: KONFIRMASI HAPUS ===== --}}
<div id="modal-hapus" class="modal-overlay">
    <div class="modal-box" style="max-width:420px;">
        <div class="modal-header">
            <div class="modal-title" style="color:var(--danger);">⚠️ Hapus Menu?</div>
            <button type="button" class="modal-close" onclick="closeModal('modal-hapus')">×</button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px; color:var(--text); line-height:1.5;">
                Apakah kamu yakin ingin menghapus menu <b id="hapus-nama">-</b>?
            </p>
            <p style="font-size:12px; color:var(--muted); margin-top:10px;">
                Tindakan ini tidak bisa dibatalkan. Foto menu juga akan dihapus.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline" onclick="closeModal('modal-hapus')">Batal</button>
            <form id="form-hapus" method="POST" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    // ===== FLASH MESSAGE AUTO-HIDE =====
    const flashMsg = document.getElementById('flash-message');
    if (flashMsg) {
        setTimeout(() => {
            flashMsg.style.opacity = '0';
            setTimeout(() => flashMsg.remove(), 600);
        }, 3000);
    }

    // ===== PAGE NAVIGATION =====
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

    // ===== MODAL HANDLERS =====
    const ROUTE_STORE  = "{{ route('penjual.stok.store') }}";
    const ROUTE_BASE   = "{{ url('penjual/stok') }}"; // /{id} ditambahkan di JS

    function openModal(id) {
        document.getElementById(id).classList.add('show');
        document.body.style.overflow = 'hidden';
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('show');
        document.body.style.overflow = '';
    }

    function openModalTambah() {
        document.getElementById('modal-menu-title').textContent  = 'Tambah Menu Baru';
        document.getElementById('modal-menu-submit').textContent = 'Tambah Menu';
        document.getElementById('form-menu').action              = ROUTE_STORE;
        document.getElementById('modal-method-field').innerHTML  = '';

        // Reset form
        document.getElementById('form-menu').reset();
        document.getElementById('f-foto-preview').style.display = 'none';
        document.getElementById('f-is_available').checked = true;

        openModal('modal-menu');
    }

    function openModalEdit(data) {
        document.getElementById('modal-menu-title').textContent  = 'Edit Menu';
        document.getElementById('modal-menu-submit').textContent = 'Simpan Perubahan';
        document.getElementById('form-menu').action              = ROUTE_BASE + '/' + data.id;
        document.getElementById('modal-method-field').innerHTML  = '<input type="hidden" name="_method" value="PUT">';

        // Isi field
        document.getElementById('f-nama_menu').value      = data.nama_menu || '';
        document.getElementById('f-kategori').value       = data.kategori || '';
        document.getElementById('f-harga').value          = data.harga || 0;
        document.getElementById('f-stok').value           = data.stok || 0;
        document.getElementById('f-deskripsi').value      = data.deskripsi || '';
        document.getElementById('f-is_available').checked = !!data.is_available;
        document.getElementById('f-foto').value           = '';

        // Preview foto lama
        if (data.foto) {
            document.getElementById('f-foto-img').src = data.foto;
            document.getElementById('f-foto-preview').style.display = 'block';
        } else {
            document.getElementById('f-foto-preview').style.display = 'none';
        }

        openModal('modal-menu');
    }

    function openModalHapus(id, nama) {
        document.getElementById('hapus-nama').textContent = nama;
        document.getElementById('form-hapus').action = ROUTE_BASE + '/' + id;
        openModal('modal-hapus');
    }

    // Tutup modal kalau klik di luar box
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeModal(overlay.id);
        });
    });

    // Tutup modal dengan ESC
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.show').forEach(m => closeModal(m.id));
        }
    });

    // Auto-buka tab Stok kalau redirect dengan #stok
    if (window.location.hash === '#stok') {
        showPage('stok');
    }

    // Auto-buka modal kalau ada validation error (UX nice-to-have)
    @if($errors->any() && old('nama_menu'))
        showPage('stok');
        openModalTambah();
        document.getElementById('f-nama_menu').value = @json(old('nama_menu'));
        document.getElementById('f-kategori').value  = @json(old('kategori'));
        document.getElementById('f-harga').value     = @json(old('harga'));
        document.getElementById('f-stok').value      = @json(old('stok'));
        document.getElementById('f-deskripsi').value = @json(old('deskripsi'));
    @endif
</script>
</body>
</html>