@extends('layouts.auth')
@section('title', 'Masuk')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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

    /* ═════════════════════════════════════ */
    /*            LAYOUT UTAMA               */
    /* ═════════════════════════════════════ */
    .login-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 100vh;
    }

    /* ═════════════════════════════════════ */
    /*            PANEL KIRI                  */
    /* ═════════════════════════════════════ */
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
        filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.15));
        transition: transform 0.3s ease;
    }

    .logo-image:hover {
        transform: scale(1.05);
    }

    .brand-name {
        font-family: 'Poppins', sans-serif;
        font-size: 36px;
        font-weight: 800;
        color: #FFE566;
        letter-spacing: 1px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .brand-tagline {
        color: rgba(255, 255, 255, 0.75);
        font-size: 14px;
        font-weight: 400;
        text-align: center;
        margin-top: 16px;
        line-height: 1.7;
        max-width: 260px;
    }

    /* ═════════════════════════════════════ */
    /*            PANEL KANAN                 */
    /* ═════════════════════════════════════ */
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
        font-family: 'Poppins', sans-serif;
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

    /* ═════════════════════════════════════ */
    /*            FORM INPUT                  */
    /* ═════════════════════════════════════ */
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

    .input-field:focus {
        border-bottom-color: #1B6B7B;
    }

    .input-field::placeholder {
        color: #aaa;
        font-size: 14px;
        font-weight: 300;
        transition: opacity 0.3s ease;
    }

    .input-field:focus::placeholder {
        opacity: 0.7;
    }

    .input-field.is-invalid {
        border-bottom-color: #e74c3c;
    }

    .error-text {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 6px;
        display: block;
        font-weight: 500;
        padding-left: 4px;
    }

    /* ═════════════════════════════════════ */
    /*         TOGGLE PASSWORD                */
    /* ═════════════════════════════════════ */
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

    .toggle-password:hover {
        color: #1B6B7B;
    }

    /* ═════════════════════════════════════ */
    /*         LUPA PASSWORD                  */
    /* ═════════════════════════════════════ */
    .forgot-password {
        text-align: right;
        margin-top: -12px;
        margin-bottom: 8px;
    }

    .forgot-password a {
        color: #1B6B7B;
        font-size: 12px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .forgot-password a:hover {
        color: #0f4a56;
        text-decoration: underline;
    }

    /* ═════════════════════════════════════ */
    /*               TOMBOL                   */
    /* ═════════════════════════════════════ */
    .btn-row {
        display: flex;
        gap: 16px;
        margin-top: 40px;
    }

    .btn-daftar {
        flex: 1;
        padding: 14px;
        border: none;
        border-radius: 50px;
        background: #F5F5A0;
        color: #333;
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
        box-shadow: 0 4px 12px rgba(245, 245, 160, 0.3);
    }

    .btn-daftar:hover {
        background: #eded7a;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(237, 237, 122, 0.4);
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
        box-shadow: 0 4px 12px rgba(27, 107, 123, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-login:hover {
        background: #155d6c;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27, 107, 123, 0.4);
    }

    .btn-login:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }

    /* ═════════════════════════════════════ */
    /*               ALERT                    */
    /* ═════════════════════════════════════ */
    .alert {
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        text-align: center;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        animation: slideDown 0.4s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* ═════════════════════════════════════ */
    /*           INFO BOX                     */
    /* ═════════════════════════════════════ */
    .info-box {
        background: #fff8e7;
        border: 1px solid #ffd966;
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 24px;
        font-size: 13px;
        color: #856404;
        line-height: 1.6;
        font-family: 'Poppins', sans-serif;
        font-weight: 400;
        box-shadow: 0 2px 8px rgba(255, 193, 7, 0.1);
    }

    /* ═════════════════════════════════════ */
    /*    MOBILE HEADER (pengganti left panel) */
    /* ═════════════════════════════════════ */
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

    .mobile-header .brand-name {
        font-size: 26px;
    }

    .mobile-header .brand-tagline {
        font-size: 13px;
        margin-top: 4px;
    }

    /* ═════════════════════════════════════ */
    /*              RESPONSIVE                 */
    /* ═════════════════════════════════════ */
    @media (max-width: 1024px) {
        .right-panel {
            padding: 48px 40px;
        }
    }

    @media (max-width: 768px) {
        .login-wrapper {
            grid-template-columns: 1fr;
            grid-template-rows: auto 1fr;
        }

        .left-panel {
            display: none;
        }

        .mobile-header {
            display: flex;
        }

        .right-panel {
            padding: 40px 24px;
            justify-content: flex-start;
        }

        .form-container {
            max-width: 100%;
        }

        .btn-row {
            flex-direction: column;
            gap: 12px;
        }

        .btn-daftar,
        .btn-login {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .mobile-header {
            padding: 24px 20px;
        }

        .mobile-header img {
            width: 64px;
            height: 64px;
        }

        .mobile-header .brand-name {
            font-size: 22px;
        }

        .right-panel {
            padding: 28px 20px;
        }

        .form-title {
            font-size: 26px;
            margin-bottom: 28px;
        }

        .form-title::after {
            width: 50px;
        }
    }
</style>
@endpush

@section('content')

{{-- MOBILE HEADER — hanya tampil di layar kecil --}}
<div class="mobile-header">
    <img src="{{ asset('images/logo.png') }}" alt="Logo KantinKu">
    <div class="brand-name">KantinKu</div>
    <p class="brand-tagline">Platform pemesanan makanan & minuman kantin sekolah yang mudah, cepat, dan praktis.</p>
</div>

<div class="login-wrapper">

    {{-- ═════════════════════════════════════ --}}
    {{--            PANEL KIRI                 --}}
    {{-- ═════════════════════════════════════ --}}
    <div class="left-panel">
        <img src="{{ asset('images/logo.png') }}" 
             alt="Logo KantinKu" 
             class="logo-image">
        <div class="brand-name">KantinKu</div>
        <p class="brand-tagline">Platform pemesanan makanan & minuman kantin sekolah yang mudah, cepat, dan praktis.</p>
    </div>

    {{-- ═════════════════════════════════════ --}}
    {{--            PANEL KANAN                 --}}
    {{-- ═════════════════════════════════════ --}}
    <div class="right-panel">
        <div class="form-container">
            
            <h1 class="form-title">Login</h1>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle" style="margin-right: 8px;"></i>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Form Login --}}
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <input type="hidden" name="role" value="siswa">

                {{-- Input NIS --}}
                <div class="input-group">
                    <input type="text"
                           name="nis"
                           id="nis"
                           class="input-field {{ $errors->has('nis') ? 'is-invalid' : '' }}"
                           placeholder="Nomor Induk Siswa (NIS)"
                           value="{{ old('nis') }}"
                           maxlength="12"
                           inputmode="numeric"
                           autofocus>
                    @error('nis')
                        <span class="error-text">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 4px;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Input Password --}}
                <div class="input-group">
                    <input type="password"
                           name="password"
                           id="password"
                           class="input-field {{ $errors->has('password') ? 'is-invalid' : '' }}"
                           placeholder="Password">
                    <button type="button" class="toggle-password" onclick="togglePassword()">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </button>
                    @error('password')
                        <span class="error-text">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 4px;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Lupa Password --}}
                <div class="forgot-password">
                    <a href="{{ route('forgot-password.index') }}">Lupa password?</a>
                </div>

                {{-- Tombol Aksi --}}
                <div class="btn-row">
                    <a href="{{ route('register') }}" class="btn-daftar">
                        <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                        Daftar
                    </a>
                    <button type="submit" class="btn-login" id="btnLogin">
                        <i class="fas fa-sign-in-alt" id="btnIcon"></i>
                        <span id="btnText">Login</span>
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Toggle show/hide password
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {

        // Loading state saat submit
        const form = document.querySelector('form');
        const btnLogin = document.getElementById('btnLogin');
        const btnIcon = document.getElementById('btnIcon');
        const btnText = document.getElementById('btnText');

        form.addEventListener('submit', function() {
            btnLogin.disabled = true;
            btnIcon.className = 'fas fa-spinner fa-spin';
            btnText.textContent = 'Masuk...';
        });

        // Auto-hide alert setelah 5 detik
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // Validasi NIS hanya angka
        const nisInput = document.getElementById('nis');
        if (nisInput) {
            nisInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        }
    });
</script>
@endpush