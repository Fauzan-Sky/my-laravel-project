<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya – KantinKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:       #1B6B7B;
            --teal-dark:  #155d6c;
            --teal-light: #e8f4f6;
            --yellow:     #FFE566;
            --danger:     #e74c3c;
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

        /* ══ NAVBAR ══ */
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

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .brand-logo {
            width: 36px; height: 36px;
            background: var(--teal);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .brand-text { font-size: 20px; font-weight: 800; color: var(--teal); letter-spacing: 0.3px; }
        .brand-text span { color: var(--text); }

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

        .nav-link:hover { background: var(--teal-light); color: var(--teal); }
        .nav-link.active { background: var(--teal-light); color: var(--teal); font-weight: 600; }

        .navbar-profile { position: relative; flex-shrink: 0; }

        .profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px 6px 6px;
            border-radius: 100px;
            border: 1.5px solid var(--teal);
            background: var(--white);
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 2px 8px rgba(27,107,123,0.12);
        }

        .profile-avatar {
            width: 32px; height: 32px;
            background: var(--teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
        }

        .profile-name { font-size: 13px; font-weight: 600; color: var(--text); max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .profile-kelas { font-size: 11px; color: var(--muted); }
        .profile-chevron { color: var(--muted); transition: transform 0.2s; }
        .profile-btn.open .profile-chevron { transform: rotate(180deg); }

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

        .dropdown-header { padding: 16px 18px 12px; border-bottom: 1px solid var(--border); }
        .dropdown-header .d-name  { font-size: 14px; font-weight: 700; color: var(--text); }
        .dropdown-header .d-nis   { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .dropdown-header .d-kelas { display: inline-block; margin-top: 6px; font-size: 11px; font-weight: 600; background: var(--teal-light); color: var(--teal); padding: 3px 10px; border-radius: 100px; }

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
        .dropdown-item.active-page { color: var(--teal); font-weight: 600; background: var(--teal-light); }
        .dropdown-item.danger { color: var(--danger); }
        .dropdown-item.danger:hover { background: #fff5f5; }

        /* ══ KONTEN ══ */
        .page-content {
            max-width: 860px;
            margin: 0 auto;
            padding: 36px 32px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            margin-bottom: 24px;
            transition: color 0.2s;
        }

        .back-link:hover { color: var(--teal); }

        /* ══ HERO PROFILE ══ */
        .profile-hero {
            background: linear-gradient(135deg, var(--teal) 0%, #0f4a56 100%);
            border-radius: 20px;
            padding: 32px 36px;
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .profile-hero::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 180px; height: 180px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .profile-hero::after {
            content: '';
            position: absolute;
            bottom: -50px; right: 100px;
            width: 140px; height: 140px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .hero-avatar {
            width: 72px; height: 72px;
            background: rgba(255,255,255,0.15);
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
            z-index: 1;
        }

        .hero-info { z-index: 1; }
        .hero-info .h-name  { font-size: 22px; font-weight: 800; color: #fff; }
        .hero-info .h-nis   { font-size: 13px; color: rgba(255,255,255,0.65); margin-top: 3px; }
        .hero-info .h-kelas {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 100px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
            color: var(--yellow);
            margin-top: 10px;
        }

        /* ══ CARD ══ */
        .card {
            background: var(--white);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-icon {
            width: 36px; height: 36px;
            background: var(--teal-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-title { font-size: 15px; font-weight: 700; color: var(--text); }
        .card-body  { padding: 24px; }

        /* ══ FORM ══ */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            color: var(--text);
            background: var(--white);
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--teal);
            box-shadow: 0 0 0 3px rgba(27,107,123,0.08);
        }

        .form-control.readonly {
            background: #f8f9fa;
            color: var(--muted);
            cursor: not-allowed;
        }

        .form-control.is-invalid { border-color: var(--danger); }

        .readonly-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-weight: 600;
            color: var(--muted);
            background: #f0f0f0;
            padding: 2px 8px;
            border-radius: 100px;
            margin-left: 6px;
        }

        .error-text {
            font-size: 11px;
            color: var(--danger);
            font-weight: 500;
            margin-top: 2px;
        }

        .password-wrap { position: relative; }
        .password-wrap .form-control { padding-right: 44px; }

        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .toggle-pw:hover { color: var(--teal); }

        /* ══ DIVIDER ══ */
        .form-divider {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 4px 0;
        }

        .form-divider::before,
        .form-divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .form-divider span { font-size: 11px; font-weight: 600; color: var(--muted); white-space: nowrap; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ══ BUTTON ══ */
        .btn-row { display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px; }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 11px 24px;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--teal);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--teal-dark);
            box-shadow: 0 4px 14px rgba(27,107,123,0.3);
            transform: translateY(-1px);
        }

        .btn-ghost {
            background: transparent;
            color: var(--muted);
            border: 1.5px solid var(--border);
        }

        .btn-ghost:hover { background: var(--bg); color: var(--text); }

        /* ══ ALERT ══ */
        .alert { padding: 13px 18px; border-radius: 12px; font-size: 13px; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* ══ INFO ROW (NIS & Kelas readonly) ══ */
        .info-note {
            font-size: 11px;
            color: var(--muted);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        @media (max-width: 768px) {
            .navbar-inner  { padding: 0 16px; }
            .page-content  { padding: 20px 16px; }
            .form-grid     { grid-template-columns: 1fr; }
            .form-group.full { grid-column: 1; }
            .profile-hero  { flex-direction: column; text-align: center; padding: 28px 20px; }
            .profile-info  { display: none; }
            .nav-link span { display: none; }
        }
    </style>
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a class="navbar-brand" href="{{ route('siswa.dashboard') }}">
            <div class="brand-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:100%; height:100%; object-fit:cover; border-radius:10px;">
            </div>
            <span class="brand-text">Kantin<span>Ku</span></span>
        </a>

        <div class="navbar-nav">
            <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Home</span>
            </a>
            <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="2"/><line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/></svg>
                <span>Pesanan Saya</span>
            </a>
            <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span>Riwayat</span>
            </a>
        </div>

        <div class="navbar-profile">
            <button class="profile-btn open" id="profileBtn" onclick="toggleDropdown()">
                <div class="profile-avatar">
                    {{ strtoupper(substr(auth('web')->user()->nama_lengkap, 0, 1)) }}
                </div>
                <div class="profile-info">
                    <div class="profile-name">{{ auth('web')->user()->nama_lengkap }}</div>
                    <div class="profile-kelas">{{ auth('web')->user()->kelas ?? '-' }}</div>
                </div>
                <svg class="profile-chevron" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
            </button>

            <div class="profile-dropdown open" id="profileDropdown">
                <div class="dropdown-header">
                    <div class="d-name">{{ auth('web')->user()->nama_lengkap }}</div>
                    <div class="d-nis">NIS: {{ auth('web')->user()->nis }}</div>
                    <span class="d-kelas">{{ auth('web')->user()->kelas ?? '-' }}</span>
                </div>
                <a href="{{ route('siswa.profile') }}" class="dropdown-item active-page">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Profil Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item danger">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- ══ KONTEN ══ --}}
<div class="page-content">

    <a href="{{ route('siswa.dashboard') }}" class="back-link">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali ke Dashboard
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- HERO --}}
    <div class="profile-hero">
        <div class="hero-avatar">
            {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
        </div>
        <div class="hero-info">
            <div class="h-name">{{ $siswa->nama_lengkap }}</div>
            <div class="h-nis">NIS: {{ $siswa->nis }}</div>
            <div class="h-kelas">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                {{ $siswa->kelas ?? '-' }}
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <form method="POST" action="{{ route('siswa.profile.update') }}">
        @csrf
        @method('PUT')

        {{-- INFORMASI PRIBADI --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <div class="card-title">Informasi Pribadi</div>
            </div>
            <div class="card-body">
                <div class="form-grid">

                    <div class="form-group">
                        <label class="form-label">
                            Nama Lengkap
                        </label>
                        <input type="text"
                               name="nama_lengkap"
                               class="form-control {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}"
                               value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                               placeholder="Masukkan nama lengkap">
                        @error('nama_lengkap')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. Telepon</label>
                        <input type="text"
                               name="no_telepon"
                               class="form-control {{ $errors->has('no_telepon') ? 'is-invalid' : '' }}"
                               value="{{ old('no_telepon', $siswa->no_telepon) }}"
                               placeholder="Contoh: 08123456789"
                               maxlength="15"
                               inputmode="numeric">
                        @error('no_telepon')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            NIS
                            <span class="readonly-badge">
                                <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Hanya Admin
                            </span>
                        </label>
                        <input type="text" class="form-control readonly" value="{{ $siswa->nis }}" readonly>
                        <div class="info-note">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            NIS hanya dapat diubah oleh admin
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Kelas
                            <span class="readonly-badge">
                                <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Hanya Admin
                            </span>
                        </label>
                        <input type="text" class="form-control readonly" value="{{ $siswa->kelas ?? '-' }}" readonly>
                        <div class="info-note">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            Kelas hanya dapat diubah oleh admin
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- UBAH PASSWORD --}}
        <div class="card">
            <div class="card-header">
                <div class="card-header-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--teal)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </div>
                <div class="card-title">Ubah Password</div>
            </div>
            <div class="card-body">
                <div class="form-grid">

                    <div class="form-group full" style="max-width: 420px;">
                        <label class="form-label">Password Baru</label>
                        <div class="password-wrap">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   placeholder="Kosongkan jika tidak ingin mengubah">
                            <button type="button" class="toggle-pw" onclick="togglePw('password','icon-pw1')">
                                <svg id="icon-pw1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group full" style="max-width: 420px;">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <div class="password-wrap">
                            <input type="password"
                                   name="password_confirmation"
                                   id="password_confirmation"
                                   class="form-control"
                                   placeholder="Ulangi password baru">
                            <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation','icon-pw2')">
                                <svg id="icon-pw2" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="btn-row">
            <a href="{{ route('siswa.dashboard') }}" class="btn btn-ghost">Batal</a>
            <button type="submit" class="btn btn-primary">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>

<script>
    function toggleDropdown() {
        document.getElementById('profileDropdown').classList.toggle('open');
        document.getElementById('profileBtn').classList.toggle('open');
    }

    document.addEventListener('click', function(e) {
        const profile = document.querySelector('.navbar-profile');
        if (!profile.contains(e.target)) {
            document.getElementById('profileDropdown').classList.remove('open');
            document.getElementById('profileBtn').classList.remove('open');
        }
    });

    function togglePw(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }

    // Auto-dismiss alert
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alert').forEach(function (alert) {
            setTimeout(function () {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity   = '0';
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        });
    });
</script>
</body>
</html>