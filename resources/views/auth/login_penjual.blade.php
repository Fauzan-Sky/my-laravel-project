@extends('layouts.auth')
@section('title', 'Login Penjual')

@push('styles')
{{-- Google Fonts --}}
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
    }

    .form-container {
        width: 100%;
        max-width: 400px;
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
        margin-bottom: 28px;
        font-size: 13px;
        color: #856404;
        line-height: 1.6;
        font-weight: 400;
    }

    .info-box strong {
        display: block;
        margin-bottom: 4px;
        font-weight: 600;
    }

    /* ── INPUT ── */
    .input-group { margin-bottom: 24px; }

    .input-field {
        width: 100%;
        padding: 16px 0 12px 0;
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
    .input-field::placeholder { color: #aaa; font-size: 14px; font-weight: 300; }
    .input-field:focus::placeholder { opacity: 0.7; }
    .input-field.is-invalid { border-bottom-color: #e74c3c; }

    .error-text {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 6px;
        display: block;
        font-weight: 500;
        padding-left: 4px;
    }

    /* ── TOMBOL ── */
    .btn-row {
        display: flex;
        gap: 16px;
        margin-top: 40px;
    }

    .btn-back {
        flex: 1;
        padding: 14px;
        border: 2px solid #e0e0e0;
        border-radius: 50px;
        background: transparent;
        color: #666;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
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

    .btn-login {
        flex: 1;
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
    }

    .btn-login:hover {
        background: #155d6c;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27,107,123,0.4);
    }

    /* ── ALERT ── */
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

    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .login-wrapper { grid-template-columns: 1fr; }
        .left-panel    { display: none; }
        .right-panel   { padding: 40px 24px; }
        .btn-row       { flex-direction: column; gap: 12px; }
    }

    @media (max-width: 480px) {
        .right-panel { padding: 32px 20px; }
        .form-title  { font-size: 28px; margin-bottom: 32px; }
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

            <h1 class="form-title">Login Penjual</h1>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Info Box --}}
            <div class="info-box">
                <strong>⚠️ Perhatian</strong>
                Gunakan email dan password yang telah disediakan oleh Admin sekolah.
                Bukan email pribadi kamu.
            </div>

            {{-- Form Login Penjual --}}
            <form method="POST" action="{{ route('login.post') }}" autocomplete="off">
                @csrf
                <input type="hidden" name="role" value="penjual">

                <div class="input-group">
                    <input type="email"
                           name="email"
                           id="email"
                           class="input-field {{ $errors->has('email') ? 'is-invalid' : '' }}"
                           placeholder="Email yang disediakan Admin"
                           value="{{ old('email') }}"
                           autofocus>
                    @error('email')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <input type="password"
                           name="password"
                           id="password"
                           class="input-field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           placeholder="Password">
                    @error('password')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                <div class="btn-row">
                    <a href="{{ route('login') }}" class="btn-back">← Kembali</a>
                    <button type="submit" class="btn-login">Login</button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // Auto-hide alert setelah 5 detik
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

    });
</script>
@endpush