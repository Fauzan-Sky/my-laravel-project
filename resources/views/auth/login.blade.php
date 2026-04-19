@extends('layouts.auth')
@section('title', 'Masuk')

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
    }

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
    }

    .btn-login:hover {
        background: #155d6c;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(27, 107, 123, 0.4);
    }

    /* ═════════════════════════════════════ */
    /*         LINK PENJUAL                   */
    /* ═════════════════════════════════════ */
    .seller-link {
        text-align: center;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .seller-link a {
        color: #1B6B7B;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .seller-link a:hover {
        color: #0f4a56;
        text-decoration: underline;
    }

    .seller-link a::after {
        content: '→';
        font-size: 18px;
        transition: transform 0.3s ease;
    }

    .seller-link a:hover::after {
        transform: translateX(4px);
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
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        }
        
        .left-panel {
            display: none;
        }
        
        .right-panel {
            padding: 40px 24px;
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
        .right-panel {
            padding: 32px 20px;
        }
        
        .form-title {
            font-size: 28px;
            margin-bottom: 32px;
        }
        
        .form-title::after {
            width: 50px;
        }
    }
</style>
@endpush

@section('content')
<div class="login-wrapper">

    {{-- ═════════════════════════════════════ --}}
    {{--            PANEL KIRI                 --}}
    {{-- ═════════════════════════════════════ --}}
    <div class="left-panel">
        <img src="{{ asset('images/logo.png') }}" 
             alt="Logo KantinKu" 
             class="logo-image">
        <div class="brand-name">KantinKu</div>
    </div>

    {{-- ═════════════════════════════════════ --}}
    {{--            PANEL KANAN                 --}}
    {{-- ═════════════════════════════════════ --}}
    <div class="right-panel">
        <div class="form-container">
            
            {{-- Judul Form --}}
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
            <form method="POST" action="{{ route('login.post') }}" autocomplete="off">
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
                    @error('password')
                        <span class="error-text">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 4px;"></i>
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="btn-row">
                    <a href="{{ route('register') }}" class="btn-daftar">
                        <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                        Daftar
                    </a>
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                        Login
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@push('scripts')
{{-- Font Awesome untuk ikon (opsional, tambah jika belum ada) --}}
<script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alert setelah 5 detik
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // Animasi input focus
        const inputs = document.querySelectorAll('.input-field');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
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