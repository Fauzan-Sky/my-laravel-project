<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kantin – KantinKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:       #1B6B7B;
            --teal-dark:  #155d6c;
            --teal-light: #e8f4f6;
            --yellow:     #FFE566;
            --text:       #1a1a1a;
            --muted:      #888;
            --border:     #e8e8e8;
            --bg:         #f4f7f8;
            --white:      #ffffff;
            --success:    #27ae60;
            --danger:     #e74c3c;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
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
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-text {
            font-size: 20px;
            font-weight: 800;
            color: var(--teal);
        }

        .brand-text span { color: var(--text); }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            background: transparent;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .back-btn:hover {
            border-color: var(--teal);
            color: var(--teal);
        }

        /* ── PAGE CONTENT ── */
        .page-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 32px;
        }

        .page-header { margin-bottom: 32px; }

        .page-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--text);
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ── KANTIN GRID ── */
        .kantin-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .kantin-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            transition: all 0.25s;
            border: 2px solid transparent;
            cursor: pointer;
            text-decoration: none;
            display: block;
            color: var(--text);
        }

        .kantin-card:hover {
            border-color: var(--teal);
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(27,107,123,0.14);
        }

        .kantin-card.tutup {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none;
        }

        .kantin-thumb {
            height: 140px;
            background: linear-gradient(135deg, var(--teal) 0%, #0f4a56 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .kantin-thumb svg { stroke: rgba(255,255,255,0.5); }

        .kantin-thumb-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .kantin-status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
        }

        .kantin-status-badge.buka {
            background: rgba(39,174,96,0.9);
            color: #fff;
        }

        .kantin-status-badge.tutup {
            background: rgba(0,0,0,0.4);
            color: #fff;
        }

        .kantin-body { padding: 18px 20px 20px; }

        .kantin-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
        }

        .kantin-lokasi {
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 12px;
        }

        .kantin-lokasi svg { stroke: var(--muted); flex-shrink: 0; }

        .kantin-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .kantin-jam {
            font-size: 12px;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .kantin-jam svg { stroke: var(--muted); }

        .kantin-arrow {
            width: 32px; height: 32px;
            background: var(--teal-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .kantin-arrow svg { stroke: var(--teal); }

        .kantin-card:hover .kantin-arrow {
            background: var(--teal);
        }

        .kantin-card:hover .kantin-arrow svg { stroke: #fff; }

        /* ── EMPTY ── */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--muted);
        }

        .empty-state svg { stroke: #ccc; margin-bottom: 12px; }
        .empty-state p { font-size: 15px; font-weight: 600; color: #555; }
        .empty-state span { font-size: 13px; }

        /* ── ALERT ── */
        .alert {
            padding: 13px 18px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 24px;
            font-weight: 500;
        }

        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        @media (max-width: 900px) {
            .kantin-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 600px) {
            .kantin-grid { grid-template-columns: 1fr; }
            .page-content { padding: 24px 16px; }
            .navbar-inner { padding: 0 16px; }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('siswa.dashboard') }}" class="navbar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo KantinKu" style="height:36px; width:auto; object-fit:contain;">
            <span class="brand-text">Kantin<span>Ku</span></span>
        </a>
        <a href="{{ route('siswa.dashboard') }}" class="back-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>
</nav>

<div class="page-content">

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="page-header">
        <div class="page-title">Pilih Kantin</div>
        <div class="page-subtitle">Pilih kantin yang ingin kamu pesan</div>
    </div>

    @if($kantinList->isEmpty())
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
                <path d="M7 2v20"/>
                <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
            </svg>
            <p>Belum ada kantin tersedia</p>
            <span>Hubungi admin untuk informasi lebih lanjut</span>
        </div>
    @else
        <div class="kantin-grid">
            @foreach($kantinList as $kantin)
            <a href="{{ $kantin->status_operasional === 'buka' ? route('siswa.menu', $kantin->id) : '#' }}"
               class="kantin-card {{ $kantin->status_operasional === 'tutup' ? 'tutup' : '' }}">

                <div class="kantin-thumb">
                    @if($kantin->foto)
                        <img src="{{ asset('storage/' . $kantin->foto) }}" alt="{{ $kantin->nama_kantinn }}" class="kantin-thumb-img">
                    @else
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/>
                            <path d="M7 2v20"/>
                            <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
                        </svg>
                    @endif
                    <span class="kantin-status-badge {{ $kantin->status_operasional }}">
                        {{ $kantin->status_operasional === 'buka' ? 'Buka' : 'Tutup' }}
                    </span>
                </div>

                <div class="kantin-body">
                    <div class="kantin-name">{{ $kantin->nama_kantinn }}</div>
                    <div class="kantin-lokasi">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                            <circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $kantin->lokasi }}
                    </div>
                    <div class="kantin-meta">
                        <div class="kantin-jam">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($kantin->jam_buka)->format('H:i') }} –
                            {{ \Carbon\Carbon::parse($kantin->jam_tutup)->format('H:i') }}
                        </div>
                        <div class="kantin-arrow">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </a>
            @endforeach
        </div>
    @endif

</div>

</body>
</html>