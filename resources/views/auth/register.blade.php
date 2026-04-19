@extends('layouts.auth')
@section('title', 'Daftar Akun Siswa')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #fff;
        min-height: 100vh;
    }

    .login-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
    }

    /* ── PANEL KIRI ── */
    .left-panel {
        background: #1B6B7B;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 48px;
        position: relative;
        border-radius: 0 32px 32px 0;
    }

    .logo-image {
        width: 160px;
        height: 160px;
        object-fit: contain;
        margin-bottom: 24px;
        filter: drop-shadow(0 8px 16px rgba(0,0,0,0.15));
        transition: transform 0.3s ease;
    }

    .logo-image:hover { transform: scale(1.05); }

    .brand-name {
        font-size: 36px;
        font-weight: 800;
        color: #FFE566;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    /* ── PANEL KANAN ── */
    .right-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 48px 64px;
        background: #fff;
        overflow-y: auto;
    }

    .form-container {
        width: 100%;
        max-width: 480px;
    }

    .form-title {
        font-size: 32px;
        font-weight: 800;
        color: #1a1a1a;
        text-align: center;
        margin-bottom: 40px;
        letter-spacing: -0.5px;
        position: relative;
    }

    .form-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 4px;
        background: #1B6B7B;
        margin: 12px auto 0;
        border-radius: 2px;
    }

    /* ── INFO BOX ── */
    .info-box {
        background: #fff8e7;
        border: 1px solid #ffd966;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 24px;
        font-size: 13px;
        color: #856404;
        line-height: 1.6;
    }

    .info-box strong {
        display: block;
        margin-bottom: 4px;
        font-weight: 600;
    }

    /* ── FORM ROW ── */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* ── INPUT ── */
    .form-group { margin-bottom: 20px; }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #555;
        margin-bottom: 6px;
    }

    .form-label .req { color: #e74c3c; }

    .input-field {
        width: 100%;
        padding: 16px 0 12px 0;
        border: none;
        border-bottom: 2px solid #e0e0e0;
        background: transparent;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #333;
        outline: none;
        transition: all 0.3s ease;
    }

    .input-field:focus { border-bottom-color: #1B6B7B; }
    .input-field::placeholder { color: #aaa; font-size: 13px; font-weight: 300; }
    .input-field:focus::placeholder { opacity: 0.7; }
    .input-field.is-invalid { border-bottom-color: #e74c3c; }

    select.input-field {
        cursor: pointer;
        background: transparent;
        appearance: none;
        -webkit-appearance: none;
    }

    .input-wrap { position: relative; }

    .pass-toggle {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #bbb;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .pass-toggle:hover { color: #1B6B7B; }

    .pass-toggle svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .error-text {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
        display: block;
        font-weight: 500;
    }

    .form-hint {
        font-size: 11px;
        color: #aaa;
        margin-top: 4px;
    }

    /* ── PASSWORD STRENGTH ── */
    .strength-bar {
        height: 3px;
        border-radius: 2px;
        background: #eee;
        overflow: hidden;
        margin-top: 8px;
    }

    .strength-fill {
        height: 100%;
        width: 0%;
        background: #e74c3c;
        transition: all 0.3s;
        border-radius: 2px;
    }

    .strength-text {
        font-size: 11px;
        color: #aaa;
        margin-top: 4px;
    }

    /* ── CHECKBOX ── */
    .check-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 24px;
        margin-top: 8px;
    }

    .check-group input {
        accent-color: #1B6B7B;
        width: 16px;
        height: 16px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .check-group label {
        font-size: 13px;
        color: #666;
        cursor: pointer;
        line-height: 1.4;
    }

    .check-group label a {
        color: #1B6B7B;
        text-decoration: none;
        font-weight: 600;
    }

    /* ── TOMBOL ── */
    .btn-row {
        display: flex;
        gap: 16px;
        margin-top: 8px;
    }

    .btn-back {
        flex: 1;
        padding: 14px;
        border: 2px solid #e0e0e0;
        border-radius: 50px;
        background: transparent;
        color: #666;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-back:hover {
        border-color: #1B6B7B;
        color: #1B6B7B;
        transform: translateY(-2px);
    }

    .btn-submit {
        flex: 1;
        padding: 14px;
        border: none;
        border-radius: 50px;
        background: #1B6B7B;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(27,107,123,0.3);
    }

    .btn-submit:hover {
        background: #155d6c;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,107,123,0.4);
    }

    .btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ── ALERT ── */
    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 13px;
        text-align: center;
        font-weight: 500;
        animation: slideDown 0.4s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* ── LINK LOGIN ── */
    .login-link {
        text-align: center;
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #eee;
        font-size: 14px;
        color: #888;
    }

    .login-link a {
        color: #1B6B7B;
        font-weight: 600;
        text-decoration: none;
    }

    .login-link a:hover { text-decoration: underline; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .login-wrapper { grid-template-columns: 1fr; }
        .left-panel    { display: none; }
        .right-panel   { padding: 40px 24px; }
        .form-row      { grid-template-columns: 1fr; gap: 0; }
        .btn-row       { flex-direction: column; gap: 12px; }
    }

    @media (max-width: 480px) {
        .right-panel { padding: 32px 20px; }
        .form-title  { font-size: 26px; }
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">

    {{-- ═══ PANEL KIRI ═══ --}}
    <div class="left-panel">
        <img src="{{ asset('images/logo.png') }}"
             alt="Logo KantinKu"
             class="logo-image">
        <div class="brand-name">KantinKu</div>
    </div>

    {{-- ═══ PANEL KANAN ═══ --}}
    <div class="right-panel">
        <div class="form-container">

            <h1 class="form-title">Daftar Akun</h1>

            {{-- Alert Error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    ❌ Mohon periksa kembali data yang kamu masukkan.
                </div>
            @endif

            {{-- Info Box --}}
            <div class="info-box">
                <strong>Catatan</strong>
                Pendaftaran hanya untuk siswa.
            </div>

            <form method="POST" action="{{ route('register.post') }}" autocomplete="off">
                @csrf

                {{-- Nama --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Depan <span class="req">*</span></label>
                        <input type="text" name="nama_depan"
                               class="input-field {{ $errors->has('nama_depan') ? 'is-invalid' : '' }}"
                               placeholder="Budi"
                               value="{{ old('nama_depan') }}"
                               autocomplete="given-name">
                        @error('nama_depan')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Belakang <span class="req">*</span></label>
                        <input type="text" name="nama_belakang"
                               class="input-field {{ $errors->has('nama_belakang') ? 'is-invalid' : '' }}"
                               placeholder="Santoso"
                               value="{{ old('nama_belakang') }}"
                               autocomplete="family-name">
                        @error('nama_belakang')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- NIS --}}
                <div class="form-group">
                    <label class="form-label">NIS (Nomor Induk Siswa) <span class="req">*</span></label>
                    <input type="text" name="nis"
                           class="input-field {{ $errors->has('nis') ? 'is-invalid' : '' }}"
                           placeholder="Contoh: 2324001234"
                           value="{{ old('nis') }}"
                           maxlength="12"
                           inputmode="numeric">
                    @error('nis')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                    <div class="form-hint">NIS ini akan digunakan untuk login</div>
                </div>

                {{-- Kelas & No HP --}}
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kelas <span class="req">*</span></label>
                        <select name="kelas"
                                class="input-field {{ $errors->has('kelas') ? 'is-invalid' : '' }}">
                            <option value="" disabled {{ old('kelas') ? '' : 'selected' }}>Pilih kelas</option>

                            {{-- ── KELAS X ── --}}
                            <optgroup label="── Kelas X ──">
                                @foreach([
                                    'X PPLG 1', 'X PPLG 2', 'X TKJ',
                                    'X PM 1', 'X PM 2',
                                    'X AKL 1', 'X AKL 2', 'X AKL 3', 'X AKL 4',
                                    'X MPLB 1', 'X MPLB 2', 'X MPLB 3', 'X MPLB 4',
                                    'X MLOG',
                                    'X DKV 1', 'X DKV 2'
                                ] as $kelas)
                                    <option value="{{ $kelas }}" {{ old('kelas') === $kelas ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </optgroup>

                            {{-- ── KELAS XI ── --}}
                            <optgroup label="── Kelas XI ──">
                                @foreach([
                                    'XI RPL 1', 'XI RPL 2', 'XI TKJ',
                                    'XI BR 1', 'XI BR 2',
                                    'XI AKL 1', 'XI AKL 2', 'XI AKL 3', 'XI AKL 4',
                                    'XI MPLB 1', 'XI MPLB 2', 'XI MPLB 3', 'XI MPLB 4',
                                    'XI DKV 1', 'XI DKV 2',
                                    'XI MLOG'
                                ] as $kelas)
                                    <option value="{{ $kelas }}" {{ old('kelas') === $kelas ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </optgroup>

                            {{-- ── KELAS XII ── --}}
                            <optgroup label="── Kelas XII ──">
                                @foreach([
                                    'XII RPL 1', 'XII RPL 2', 'XII TKJ',
                                    'XII BR 1', 'XII BR 2',
                                    'XII DKV 1', 'XII DKV 2',
                                    'XII AKL 1', 'XII AKL 2', 'XII AKL 3', 'XII AKL 4',
                                    'XII MPLB 1', 'XII MPLB 2', 'XII MPLB 3', 'XII MPLB 4',
                                    'XII MLOG'
                                ] as $kelas)
                                    <option value="{{ $kelas }}" {{ old('kelas') === $kelas ? 'selected' : '' }}>
                                        {{ $kelas }}
                                    </option>
                                @endforeach
                            </optgroup>

                        </select>
                        @error('kelas')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. HP</label>
                        <input type="tel" name="no_hp"
                               class="input-field {{ $errors->has('no_hp') ? 'is-invalid' : '' }}"
                               placeholder="08xxxxxxxxxx"
                               value="{{ old('no_hp') }}"
                               maxlength="15">
                        @error('no_hp')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">Password <span class="req">*</span></label>
                    <div class="input-wrap">
                        <input type="password" name="password" id="password"
                               class="input-field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Minimal 8 karakter"
                               autocomplete="new-password">
                        <button type="button" class="pass-toggle" onclick="togglePass('password', this)" title="Tampilkan password">
                            <svg id="eye-icon-1" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                    <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                    <div class="strength-text" id="strength-text"></div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password <span class="req">*</span></label>
                    <div class="input-wrap">
                        <input type="password" name="password_confirmation" id="password2"
                               class="input-field"
                               placeholder="Ulangi password"
                               autocomplete="new-password">
                        <button type="button" class="pass-toggle" onclick="togglePass('password2', this)" title="Tampilkan password">
                            <svg id="eye-icon-2" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Syarat & Ketentuan --}}
                <div class="check-group">
                    <input type="checkbox" name="agree" id="agree" {{ old('agree') ? 'checked' : '' }}>
                    <label for="agree">
                        Saya setuju dengan <a href="#">Syarat & Ketentuan</a> dan <a href="#">Kebijakan Privasi</a>
                    </label>
                </div>

                {{-- Tombol --}}
                <div class="btn-row">
                    <a href="{{ route('login') }}" class="btn-back">← Kembali</a>
                    <button type="submit" class="btn-submit" id="btn-reg">Daftar</button>
                </div>

            </form>

            {{-- Link ke Login --}}
            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // SVG icon eye & eye-off
    const eyeIcon = `<svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
    const eyeOffIcon = `<svg viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;

    function togglePass(id, btn) {
        const inp = document.getElementById(id);
        if (inp.type === 'password') {
            inp.type = 'text';
            btn.innerHTML = eyeOffIcon;
            btn.title = 'Sembunyikan password';
        } else {
            inp.type = 'password';
            btn.innerHTML = eyeIcon;
            btn.title = 'Tampilkan password';
        }
    }

    // Password strength indicator
    document.getElementById('password').addEventListener('input', function () {
        const val  = this.value;
        let score  = 0;
        if (val.length >= 8)           score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^A-Za-z0-9]/.test(val))  score++;

        const fill   = document.getElementById('strength-fill');
        const text   = document.getElementById('strength-text');
        const colors = ['#e74c3c', '#e74c3c', '#f39c12', '#1B6B7B', '#1B6B7B'];
        const labels = ['', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];

        fill.style.width      = (score * 25) + '%';
        fill.style.background = colors[score];
        text.textContent      = val.length ? labels[score] : '';
    });

    // Disable tombol daftar jika belum centang syarat
    const agreeBox = document.getElementById('agree');
    const btnReg   = document.getElementById('btn-reg');

    agreeBox.addEventListener('change', function () {
        btnReg.disabled = !this.checked;
    });

    // Init state
    btnReg.disabled = !agreeBox.checked;

    // Validasi NIS hanya angka
    document.querySelector('input[name="nis"]').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush