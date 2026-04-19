<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa – KantinKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:       #1B6B7B;
            --teal-dark:  #155d6c;
            --teal-light: #e8f4f6;
            --yellow:     #FFE566;
            --danger:     #e74c3c;
            --warning:    #f39c12;
            --success:    #27ae60;
            --text:       #1a1a1a;
            --muted:      #888;
            --border:     #e8e8e8;
            --bg:         #f4f7f8;
            --white:      #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ════════════════════════════
           NAVBAR
        ════════════════════════════ */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 12px rgba(0,0,0,0.06);
        }

        .navbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
        }

        /* ── Logo ── */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            background: var(--teal);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo svg {
            stroke: #fff;
        }

        .brand-text {
            font-size: 20px;
            font-weight: 800;
            color: var(--teal);
            letter-spacing: 0.3px;
        }

        .brand-text span {
            color: var(--text);
        }

        /* ── Nav Links ── */
        .navbar-nav {
            display: flex;
            align-items: center;
            gap: 4px;
            flex: 1;
            justify-content: center;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
            border: none;
            background: transparent;
            font-family: 'Poppins', sans-serif;
        }

        .nav-link:hover {
            background: var(--teal-light);
            color: var(--teal);
        }

        .nav-link.active {
            background: var(--teal-light);
            color: var(--teal);
            font-weight: 600;
        }

        .nav-link svg {
            flex-shrink: 0;
        }

        /* ── Profile ── */
        .navbar-profile {
            position: relative;
            flex-shrink: 0;
        }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px 6px 6px;
            border-radius: 100px;
            border: 1.5px solid var(--border);
            background: var(--white);
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Poppins', sans-serif;
        }

        .profile-btn:hover {
            border-color: var(--teal);
            box-shadow: 0 2px 8px rgba(27,107,123,0.12);
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            background: var(--teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .profile-info {
            text-align: left;
        }

        .profile-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            max-width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-kelas {
            font-size: 11px;
            color: var(--muted);
        }

        .profile-chevron {
            color: var(--muted);
            transition: transform 0.2s;
        }

        .profile-btn.open .profile-chevron {
            transform: rotate(180deg);
        }

        /* ── Dropdown ── */
        .profile-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            min-width: 220px;
            overflow: hidden;
            display: none;
            z-index: 200;
        }

        .profile-dropdown.open { display: block; }

        .dropdown-header {
            padding: 16px 18px 12px;
            border-bottom: 1px solid var(--border);
        }

        .dropdown-header .d-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
        }

        .dropdown-header .d-nis {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        .dropdown-header .d-kelas {
            display: inline-block;
            margin-top: 6px;
            font-size: 11px;
            font-weight: 600;
            background: var(--teal-light);
            color: var(--teal);
            padding: 3px 10px;
            border-radius: 100px;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 18px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            text-decoration: none;
            transition: background 0.15s;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            font-family: 'Poppins', sans-serif;
        }

        .dropdown-item:hover { background: var(--bg); }

        .dropdown-item svg { stroke: var(--muted); flex-shrink: 0; }

        .dropdown-item.danger { color: var(--danger); }
        .dropdown-item.danger svg { stroke: var(--danger); }
        .dropdown-item.danger:hover { background: #fff5f5; }

        .dropdown-divider {
            height: 1px;
            background: var(--border);
            margin: 4px 0;
        }

        /* ════════════════════════════
           PAGE CONTENT
        ════════════════════════════ */
        .page-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 36px 32px;
        }

        /* ════════════════════════════
           HOME PAGE
        ════════════════════════════ */
        .hero-banner {
            background: linear-gradient(135deg, var(--teal) 0%, #0f4a56 100%);
            border-radius: 20px;
            padding: 36px 40px;
            color: #fff;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            bottom: -60px; right: 80px;
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .hero-greeting {
            font-size: 13px;
            color: rgba(255,255,255,0.65);
            margin-bottom: 6px;
            font-weight: 500;
        }

        .hero-name {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 4px;
        }

        .hero-sub {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 100px;
            padding: 5px 14px;
            font-size: 12px;
            font-weight: 600;
            color: var(--yellow);
            margin-top: 14px;
        }

        /* ── Stat Cards ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 16px;
            padding: 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.09);
        }

        .stat-icon {
            width: 50px; height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon.teal   { background: var(--teal-light); }
        .stat-icon.teal svg   { stroke: var(--teal); }
        .stat-icon.yellow { background: #fff8e1; }
        .stat-icon.yellow svg { stroke: #d4a017; }
        .stat-icon.green  { background: #eafaf1; }
        .stat-icon.green svg  { stroke: var(--success); }

        .stat-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
            line-height: 1.2;
            margin-top: 2px;
        }

        .stat-sub {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── Section Heading ── */
        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .section-link {
            font-size: 13px;
            color: var(--teal);
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: transparent;
            font-family: 'Poppins', sans-serif;
        }

        .section-link:hover { text-decoration: underline; }

        /* ── Kantin Cards ── */
        .kantin-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .kantin-card {
            background: var(--white);
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            transition: all 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .kantin-card:hover {
            border-color: var(--teal);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(27,107,123,0.12);
        }

        .kantin-icon {
            width: 44px; height: 44px;
            background: var(--teal-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
        }

        .kantin-icon svg { stroke: var(--teal); }

        .kantin-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .kantin-lokasi {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .kantin-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 100px;
        }

        .kantin-status.buka {
            background: #eafaf1;
            color: var(--success);
        }

        .kantin-status.tutup {
            background: #f8f8f8;
            color: var(--muted);
        }

        .kantin-status.buka::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--success);
        }

        /* ════════════════════════════
           PESANAN & RIWAYAT
        ════════════════════════════ */
        .card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--muted);
            padding: 10px 16px;
            background: #fafafa;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        tbody td {
            padding: 14px 16px;
            font-size: 13px;
            color: var(--text);
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fafcfc; }

        /* ── Badge ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-pending    { background: #fff3cd; color: #856404; }
        .badge-processing { background: #cce5ff; color: #004085; }
        .badge-ready      { background: #d4edda; color: #155724; }
        .badge-picked     { background: #e2e3e5; color: #383d41; }

        /* ── Antrean badge ── */
        .antrean-badge {
            background: var(--teal);
            color: #fff;
            font-weight: 800;
            font-size: 13px;
            padding: 4px 10px;
            border-radius: 8px;
            display: inline-block;
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: var(--muted);
        }

        .empty-state .empty-icon {
            margin-bottom: 12px;
            display: flex;
            justify-content: center;
            color: #ccc;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 4px;
            font-weight: 500;
            color: #555;
        }

        .empty-state span {
            font-size: 12px;
            color: var(--muted);
        }

        /* ── Alert ── */
        .alert {
            padding: 13px 18px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* ── Tab bar ── */
        .tab-bar {
            display: flex;
            gap: 4px;
            background: #f0f0f0;
            border-radius: 10px;
            padding: 4px;
            margin-bottom: 20px;
            width: fit-content;
        }

        .tab-btn {
            padding: 8px 20px;
            border-radius: 8px;
            border: none;
            background: transparent;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab-btn.active {
            background: var(--white);
            color: var(--teal);
            font-weight: 700;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        /* ── Page header ── */
        .page-header {
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 800;
            color: var(--text);
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--muted);
            margin-top: 3px;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .navbar-inner { padding: 0 16px; }
            .page-content { padding: 24px 16px; }
            .stat-grid    { grid-template-columns: 1fr 1fr; }
            .kantin-grid  { grid-template-columns: 1fr; }
            .profile-info { display: none; }
            .navbar-nav   { gap: 0; }
            .nav-link span { display: none; }
        }
    </style>
</head>
<body>

{{-- ════════════════════════════════
     NAVBAR
════════════════════════════════ --}}
<nav class="navbar">
    <div class="navbar-inner">

        {{-- Logo --}}
        <a class="navbar-brand" href="#" onclick="showPage('home')">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" 
                    alt="Logo KantinKu" 
                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
            </div>
            <span class="brand-text">Kantin<span>Ku</span></span>
        </a>

        {{-- Nav Links --}}
        <div class="navbar-nav">
            <button class="nav-link active" id="nav-home" onclick="showPage('home')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Home</span>
            </button>
            <button class="nav-link" id="nav-pesanan" onclick="showPage('pesanan')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="2"/>
                    <line x1="9" y1="12" x2="15" y2="12"/>
                    <line x1="9" y1="16" x2="13" y2="16"/>
                </svg>
                <span>Pesanan Saya</span>
            </button>
            <button class="nav-link" id="nav-riwayat" onclick="showPage('riwayat')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
                <span>Riwayat</span>
            </button>
        </div>

        {{-- Profile --}}
        <div class="navbar-profile">
            <button class="profile-btn" id="profileBtn" onclick="toggleDropdown()">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth('web')->user()->nama_lengkap, 0, 1)) }}
                </div>
                <div class="profile-info">
                    <div class="profile-name">{{ auth('web')->user()->nama_lengkap }}</div>
                    <div class="profile-kelas">{{ auth('web')->user()->kelas ?? '-' }}</div>
                </div>
                <svg class="profile-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <div class="dropdown-header">
                    <div class="d-name">{{ auth('web')->user()->nama_lengkap }}</div>
                    <div class="d-nis">NIS: {{ auth('web')->user()->nis }}</div>
                    <span class="d-kelas">{{ auth('web')->user()->kelas ?? '-' }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item danger">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>

{{-- ════════════════════════════════
     PAGE CONTENT
════════════════════════════════ --}}
<div class="page-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ══ PAGE: HOME ══ --}}
    <div id="page-home">

        {{-- Hero --}}
        <div class="hero-banner">
            <div class="hero-greeting">Selamat datang kembali,</div>
            <div class="hero-name">{{ auth('web')->user()->nama_lengkap }}</div>
            <div class="hero-sub">{{ now()->translatedFormat('l, d F Y') }}</div>
            <div class="hero-badge">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
                {{ auth('web')->user()->kelas ?? 'Siswa' }}
            </div>
        </div>

        {{-- Daftar Kantin --}}
        <div class="section-heading">
            <div class="section-title">Kantin Tersedia</div>
        </div>

        <div class="kantin-grid">
            @forelse($kantinList ?? [] as $kantin)
                @if($kantin->status_operasional === 'buka')
                <a href="{{ route('siswa.pilih.menu', $kantin->id) }}" class="kantin-card" style="text-decoration:none; display:block;">
                @else
                <div class="kantin-card tutup">
                @endif
                    <div class="kantin-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
                            <path d="M7 2v20"/>
                            <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
                        </svg>
                    </div>
                    <div class="kantin-name">{{ $kantin->nama_kantinn }}</div>
                    <span class="kantin-status {{ $kantin->status_operasional }}">
                        {{ $kantin->status_operasional === 'buka' ? 'Sedang Buka' : 'Tutup' }}
                    </span>
                @if($kantin->status_operasional === 'buka')
                </a>
                @else
                </div>
                @endif
            @empty
            <div style="grid-column: 1/-1">
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
                            <path d="M7 2v20"/>
                            <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
                        </svg>
                    </div>
                    <p>Belum ada kantin tersedia</p>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pesanan Terbaru --}}
        <div class="section-heading">
            <div class="section-title">Pesanan Terbaru</div>
            <button class="section-link" onclick="showPage('pesanan')">Lihat Semua</button>
        </div>

        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No. Antrean</th>
                            <th>Kantin</th>
                            <th>Total</th>
                            <th>Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesananTerbaru ?? [] as $p)
                        <tr>
                            <td><span class="antrean-badge">#{{ str_pad($p->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</span></td>
                            <td>{{ $p->kantin->nama_kantinn ?? '-' }}</td>
                            <td style="font-weight:700">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td style="color:var(--muted); font-size:12px">{{ $p->created_at->format('H:i') }}</td>
                            <td>
                                @php
                                    $cls = match($p->status) { 'pending'=>'badge-pending','processing'=>'badge-processing','ready'=>'badge-ready','picked'=>'badge-picked',default=>'badge-pending'};
                                    $lbl = match($p->status) { 'pending'=>'Menunggu','processing'=>'Diproses','ready'=>'Siap Diambil','picked'=>'Sudah Diambil',default=>$p->status};
                                @endphp
                                <span class="badge {{ $cls }}">{{ $lbl }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/>
                                        <path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>
                                    </svg>
                                </div>
                                <p>Belum ada pesanan</p>
                                <span>Pesanan kamu akan muncul di sini</span>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ══ PAGE: PESANAN SAYA ══ --}}
    <div id="page-pesanan" style="display:none">

        <div class="page-header">
            <div class="page-title">Pesanan Saya</div>
            <div class="page-subtitle">Pantau status pesanan kamu saat ini</div>
        </div>

        <div class="tab-bar">
            <button class="tab-btn active" onclick="filterStatus('semua', this)">Semua</button>
            <button class="tab-btn" onclick="filterStatus('pending', this)">Menunggu</button>
            <button class="tab-btn" onclick="filterStatus('processing', this)">Diproses</button>
            <button class="tab-btn" onclick="filterStatus('ready', this)">Siap Diambil</button>
        </div>

        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No. Antrean</th>
                            <th>Kantin</th>
                            <th>Menu</th>
                            <th>Total</th>
                            <th>Waktu Pesan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesananAktifList ?? [] as $p)
                        <tr data-status="{{ $p->status }}">
                            <td><span class="antrean-badge">#{{ str_pad($p->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</span></td>
                            <td>{{ $p->kantin->nama_kantinn ?? '-' }}</td>
                            <td style="font-size:12px; max-width:160px">
                                @foreach($p->detailPesanan as $d)
                                    <div>{{ $d->menu->nama_menu ?? '-' }} <span style="color:var(--muted)">x{{ $d->jumlah }}</span></div>
                                @endforeach
                            </td>
                            <td style="font-weight:700">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td style="color:var(--muted); font-size:12px">{{ $p->created_at->format('d/m H:i') }}</td>
                            <td>
                                @php
                                    $cls = match($p->status) { 'pending'=>'badge-pending','processing'=>'badge-processing','ready'=>'badge-ready','picked'=>'badge-picked',default=>'badge-pending'};
                                    $lbl = match($p->status) { 'pending'=>'Menunggu','processing'=>'Diproses','ready'=>'Siap Diambil','picked'=>'Sudah Diambil',default=>$p->status};
                                @endphp
                                <span class="badge {{ $cls }}">{{ $lbl }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                                        <rect x="9" y="3" width="6" height="4" rx="2"/>
                                    </svg>
                                </div>
                                <p>Tidak ada pesanan aktif</p>
                                <span>Pesanan yang sedang berjalan akan tampil di sini</span>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ══ PAGE: RIWAYAT ══ --}}
    <div id="page-riwayat" style="display:none">

        <div class="page-header">
            <div class="page-title">Riwayat Pesanan</div>
            <div class="page-subtitle">Semua riwayat pesanan kamu</div>
        </div>

        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No. Antrean</th>
                            <th>Kantin</th>
                            <th>Menu</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPesanan ?? [] as $p)
                        <tr>
                            <td><span class="antrean-badge">#{{ str_pad($p->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</span></td>
                            <td>{{ $p->kantin->nama_kantinn ?? '-' }}</td>
                            <td style="font-size:12px; max-width:160px">
                                @foreach($p->detailPesanan as $d)
                                    <div>{{ $d->menu->nama_menu ?? '-' }} <span style="color:var(--muted)">x{{ $d->jumlah }}</span></div>
                                @endforeach
                            </td>
                            <td style="font-weight:700">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td style="color:var(--muted); font-size:12px">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @php
                                    $cls = match($p->status) { 'pending'=>'badge-pending','processing'=>'badge-processing','ready'=>'badge-ready','picked'=>'badge-picked',default=>'badge-pending'};
                                    $lbl = match($p->status) { 'pending'=>'Menunggu','processing'=>'Diproses','ready'=>'Siap Diambil','picked'=>'Sudah Diambil',default=>$p->status};
                                @endphp
                                <span class="badge {{ $cls }}">{{ $lbl }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                </div>
                                <p>Belum ada riwayat pesanan</p>
                                <span>Riwayat pesanan kamu akan muncul di sini</span>
                            </div>
                        </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    // ── Navigasi halaman ──
    function showPage(page) {
        ['home', 'pesanan', 'riwayat'].forEach(p => {
            document.getElementById('page-' + p).style.display = p === page ? 'block' : 'none';
        });

        document.querySelectorAll('.nav-link').forEach(el => {
            el.classList.remove('active');
        });

        const activeNav = document.getElementById('nav-' + page);
        if (activeNav) activeNav.classList.add('active');

        closeDropdown();
    }

    // ── Profile dropdown ──
    function toggleDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        const btn      = document.getElementById('profileBtn');
        dropdown.classList.toggle('open');
        btn.classList.toggle('open');
    }

    function closeDropdown() {
        document.getElementById('profileDropdown').classList.remove('open');
        document.getElementById('profileBtn').classList.remove('open');
    }

    // Tutup dropdown kalau klik di luar
    document.addEventListener('click', function(e) {
        const profile = document.querySelector('.navbar-profile');
        if (!profile.contains(e.target)) closeDropdown();
    });

    // ── Filter status pesanan ──
    function filterStatus(status, btn) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('tbody tr[data-status]').forEach(row => {
            row.style.display = (status === 'semua' || row.dataset.status === status) ? '' : 'none';
        });
    }

    // ============================================================
    // ⭐ AUTO HIDE ALERT NOTIFIKASI SETELAH 3 DETIK ⭐
    // ============================================================
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-success, .alert-danger');
        
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                
                setTimeout(function() {
                    alert.remove();
                }, 500);
            }, 3000); // 3 detik
        });
    });
</script>

</body>
</html>