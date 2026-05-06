@extends('layouts.auth')
@section('title', 'Lupa Password')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

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

    /* ═══════════════════════════ */
    /*         PANEL KIRI          */
    /* ═══════════════════════════ */
    .left-panel {
        background: #1B6B7B;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 48px;
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

    .brand-tagline {
        color: rgba(255,255,255,0.75);
        font-size: 14px;
        font-weight: 400;
        text-align: center;
        margin-top: 16px;
        line-height: 1.7;
        max-width: 260px;
    }

    /* ═══════════════════════════ */
    /*         PANEL KANAN         */
    /* ═══════════════════════════ */
    .right-panel {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 48px 64px;
        background: #fff;
    }

    .form-container {
        width: 100%;
        max-width: 400px;
    }

    .form-title {
        font-size: 28px;
        font-weight: 800;
        color: #1a1a1a;
        text-align: center;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
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

    .form-subtitle {
        text-align: center;
        color: #888;
        font-size: 13px;
        margin-bottom: 32px;
        line-height: 1.6;
    }

    /* Steps indicator */
    .steps {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 32px;
        gap: 0;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e0e0e0;
        color: #aaa;
        font-size: 13px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .step-circle.active {
        background: #1B6B7B;
        color: #fff;
    }

    .step-circle.done {
        background: #27ae60;
        color: #fff;
    }

    .step-label {
        font-size: 11px;
        color: #aaa;
        font-weight: 500;
        white-space: nowrap;
    }

    .step-label.active { color: #1B6B7B; }
    .step-label.done   { color: #27ae60; }

    .step-line {
        width: 60px;
        height: 2px;
        background: #e0e0e0;
        margin-bottom: 18px;
        transition: background 0.3s ease;
    }

    .step-line.done { background: #27ae60; }

    /* Input */
    .input-group {
        margin-bottom: 24px;
        position: relative;
    }

    .input-field {
        width: 100%;
        padding: 16px 40px 12px 0;
        border: none;
        border-bottom: 2px solid #e0e0e0;
        background: transparent;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        color: #333;
        outline: none;
        transition: all 0.3s ease;
    }

    .input-field:focus { border-bottom-color: #1B6B7B; }

    .input-field::placeholder {
        color: #aaa;
        font-size: 14px;
        font-weight: 300;
    }

    .input-field.is-invalid { border-bottom-color: #e74c3c; }

    .error-text {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 6px;
        display: block;
        font-weight: 500;
    }

    .toggle-password {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-60%);
        background: none;
        border: none;
        cursor: pointer;
        color: #aaa;
        font-size: 16px;
        padding: 4px;
        transition: color 0.3s ease;
        outline: none;
    }

    .toggle-password:hover { color: #1B6B7B; }

    /* Alert */
    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
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

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Tombol */
    .btn-primary {
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 50px;
        background: #1B6B7B;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(27,107,123,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 32px;
    }

    .btn-primary:hover {
        background: #155d6c;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,107,123,0.4);
    }

    .btn-primary:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    .back-link {
        text-align: center;
        margin-top: 20px;
    }

    .back-link a {
        color: #1B6B7B;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .back-link a:hover {
        color: #0f4a56;
        text-decoration: underline;
    }

    /* Mobile header */
    .mobile-header {
        display: none;
        background: #1B6B7B;
        padding: 32px 24px;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 12px;
    }

    .mobile-header img {
        width: 80px;
        height: 80px;
        object-fit: contain;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));
    }

    .mobile-header .brand-name { font-size: 26px; }
    .mobile-header .brand-tagline { font-size: 13px; margin-top: 4px; }

    /* Responsive */
    @media (max-width: 768px) {
        .login-wrapper {
            grid-template-columns: 1fr;
        }
        .left-panel { display: none; }
        .mobile-header { display: flex; }
        .right-panel {
            padding: 40px 24px;
            justify-content: flex-start;
        }
    }

    @media (max-width: 480px) {
        .mobile-header { padding: 24px 20px; }
        .mobile-header img { width: 64px; height: 64px; }
        .mobile-header .brand-name { font-size: 22px; }
        .right-panel { padding: 28px 20px; }
        .form-title { font-size: 24px; }
        .step-line { width: 40px; }
    }
</style>
@endpush

@section('content')

<div class="mobile-header">
    <img src="{{ asset('images/logo.png') }}" alt="Logo KantinKu">
    <div class="brand-name">KantinKu</div>
    <p class="brand-tagline">Platform pemesanan makanan & minuman kantin sekolah yang mudah, cepat, dan praktis.</p>
</div>

<div class="login-wrapper">

    {{-- PANEL KIRI --}}
    <div class="left-panel">
        <img src="{{ asset('images/logo.png') }}" alt="Logo KantinKu" class="logo-image">
        <div class="brand-name">KantinKu</div>
        <p class="brand-tagline">Platform pemesanan makanan & minuman kantin sekolah yang mudah, cepat, dan praktis.</p>
    </div>

    {{-- PANEL KANAN --}}
    <div class="right-panel">
        <div class="form-container">

            {{-- Step Indicator --}}
            <div class="steps">
                <div class="step">
                    <div class="step-circle {{ session('verified') ? 'done' : 'active' }}">
                        {{ session('verified') ? '✓' : '1' }}
                    </div>
                    <span class="step-label {{ session('verified') ? 'done' : 'active' }}">Verifikasi</span>
                </div>
                <div class="step-line {{ session('verified') ? 'done' : '' }}"></div>
                <div class="step">
                    <div class="step-circle {{ session('verified') ? 'active' : '' }}">2</div>
                    <span class="step-label {{ session('verified') ? 'active' : '' }}">Password Baru</span>
                </div>
            </div>

            @if(!session('verified'))
                {{-- ══════════════════════════ --}}
                {{-- STEP 1: FORM VERIFIKASI   --}}
                {{-- ══════════════════════════ --}}
                <h1 class="form-title">Lupa Password</h1>
                <p class="form-subtitle">Masukkan NIS dan nama lengkap kamu untuk melanjutkan.</p>

                @if($errors->has('verifikasi'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                        {{ $errors->first('verifikasi') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('forgot-password.verifikasi') }}">
                    @csrf

                    <div class="input-group">
                        <input type="text"
                               name="nis"
                               class="input-field {{ $errors->has('nis') ? 'is-invalid' : '' }}"
                               placeholder="Nomor Induk Siswa (NIS)"
                               value="{{ old('nis') }}"
                               maxlength="12"
                               inputmode="numeric"
                               autofocus>
                        @error('nis')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <input type="text"
                               name="nama_lengkap"
                               class="input-field {{ $errors->has('nama_lengkap') ? 'is-invalid' : '' }}"
                               placeholder="Nama Lengkap"
                               value="{{ old('nama_lengkap') }}">
                        @error('nama_lengkap')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-primary" id="btnVerifikasi">
                        <i class="fas fa-arrow-right" id="btnVerifikasiIcon"></i>
                        <span id="btnVerifikasiText">Verifikasi</span>
                    </button>
                </form>

            @else
                {{-- ══════════════════════════ --}}
                {{-- STEP 2: FORM PASSWORD BARU --}}
                {{-- ══════════════════════════ --}}
                <h1 class="form-title">Password Baru</h1>
                <p class="form-subtitle">Buat password baru untuk akun kamu.</p>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('forgot-password.reset') }}">
                    @csrf

                    <div class="input-group">
                        <input type="password"
                               name="password"
                               id="password"
                               class="input-field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Password Baru (min. 6 karakter)">
                        <button type="button" class="toggle-password" onclick="togglePassword('password', 'iconPassword')">
                            <i class="fas fa-eye" id="iconPassword"></i>
                        </button>
                        @error('password')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="input-field"
                               placeholder="Konfirmasi Password">
                        <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation', 'iconConfirm')">
                            <i class="fas fa-eye" id="iconConfirm"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn-primary" id="btnReset">
                        <i class="fas fa-key" id="btnResetIcon"></i>
                        <span id="btnResetText">Simpan Password</span>
                    </button>
                </form>
            @endif

            <div class="back-link">
                <a href="{{ route('login') }}">
                    <i class="fas fa-arrow-left" style="margin-right: 4px;"></i>
                    Kembali ke Login
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Loading state tombol verifikasi
        const formVerifikasi = document.querySelector('form');
        if (formVerifikasi) {
            formVerifikasi.addEventListener('submit', function () {
                const btn  = document.getElementById('btnVerifikasi') || document.getElementById('btnReset');
                const icon = document.getElementById('btnVerifikasiIcon') || document.getElementById('btnResetIcon');
                const text = document.getElementById('btnVerifikasiText') || document.getElementById('btnResetText');
                if (btn)  btn.disabled = true;
                if (icon) icon.className = 'fas fa-spinner fa-spin';
                if (text) text.textContent = 'Memproses...';
            });
        }

        // Validasi NIS hanya angka
        const nisInput = document.querySelector('input[name="nis"]');
        if (nisInput) {
            nisInput.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });
</script>
@endpush