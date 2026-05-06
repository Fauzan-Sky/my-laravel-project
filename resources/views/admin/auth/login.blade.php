<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Kantinku2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-color: #0b1f2a;
            background-image:
                radial-gradient(ellipse at 20% 50%, rgba(26, 122, 122, 0.18) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(15, 76, 92, 0.22) 0%, transparent 55%),
                radial-gradient(ellipse at 60% 80%, rgba(6, 78, 78, 0.15) 0%, transparent 50%);
            position: relative;
            overflow: hidden;
        }

        /* Animated floating orbs */
        body::before {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(26,122,122,0.12) 0%, transparent 70%);
            top: -100px;
            left: -100px;
            animation: float1 10s ease-in-out infinite;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(15,76,92,0.14) 0%, transparent 70%);
            bottom: -80px;
            right: -80px;
            animation: float2 12s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50%       { transform: translate(30px, 40px) scale(1.08); }
        }

        @keyframes float2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50%       { transform: translate(-25px, -35px) scale(1.06); }
        }

        /* Grid pattern overlay */
        .grid-overlay {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(26,122,122,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(26,122,122,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
        }

        /* Header */
        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-ring {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 68px;
            height: 68px;
            border-radius: 20px;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #1a7a7a, #0f4c5c);
            box-shadow: 0 8px 32px rgba(26,122,122,0.40), 0 0 0 1px rgba(26,122,122,0.3);
            position: relative;
        }

        .logo-ring::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 23px;
            border: 1.5px solid rgba(26,122,122,0.35);
        }

        .login-title {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.3px;
        }

        .login-subtitle {
            font-size: 13px;
            color: rgba(255,255,255,0.50);
            margin-top: 4px;
        }

        /* Card */
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 24px;
            padding: 36px 36px 32px;
            box-shadow:
                0 24px 64px rgba(0,0,0,0.40),
                inset 0 1px 0 rgba(255,255,255,0.08);
        }

        /* Divider label */
        .section-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            margin-bottom: 20px;
        }

        /* Form fields */
        .field-group {
            margin-bottom: 18px;
        }

        .field-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.75);
            margin-bottom: 7px;
        }

        .field-input {
            width: 100%;
            padding: 11px 14px;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            background: rgba(255,255,255,0.07);
            border: 1.5px solid rgba(255,255,255,0.10);
            color: #ffffff;
            outline: none;
            transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
        }

        .field-input::placeholder {
            color: rgba(255,255,255,0.25);
        }

        .field-input:focus {
            border-color: #1a7a7a;
            background: rgba(26,122,122,0.12);
            box-shadow: 0 0 0 3px rgba(26,122,122,0.20);
        }

        .field-error {
            margin-top: 5px;
            font-size: 11px;
            color: #fca5a5;
        }

        /* Password wrapper */
        .password-wrap {
            position: relative;
        }

        .password-wrap .field-input {
            padding-right: 44px;
        }

        .toggle-pass {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: rgba(255,255,255,0.35);
            transition: color 0.2s;
            padding: 4px;
            display: flex;
            align-items: center;
        }

        .toggle-pass:hover { color: #1a7a7a; }

        /* Remember */
        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }

        .remember-row input[type="checkbox"] {
            accent-color: #1a7a7a;
            width: 15px;
            height: 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .remember-row label {
            font-size: 13px;
            color: rgba(255,255,255,0.50);
            cursor: pointer;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            border: none;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #ffffff;
            cursor: pointer;
            background: linear-gradient(135deg, #1a7a7a 0%, #0f4c5c 100%);
            box-shadow: 0 6px 24px rgba(26,122,122,0.40);
            transition: opacity 0.2s, transform 0.2s, box-shadow 0.2s;
            letter-spacing: 0.2px;
        }

        .btn-submit:hover {
            opacity: 0.90;
            transform: translateY(-1px);
            box-shadow: 0 10px 30px rgba(26,122,122,0.50);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Alert */
        .alert-error {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 13px;
            background: rgba(248,113,113,0.12);
            border: 1px solid rgba(248,113,113,0.30);
            color: #fca5a5;
        }

        .alert-success {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 12px;
            font-size: 13px;
            background: rgba(52,211,153,0.12);
            border: 1px solid rgba(52,211,153,0.30);
            color: #6ee7b7;
        }

        /* Back link */
        .back-link {
            text-align: center;
            margin-top: 22px;
        }

        .back-link a {
            font-size: 13px;
            color: rgba(255,255,255,0.40);
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link a:hover { color: rgba(255,255,255,0.85); }

        /* Separator */
        .separator {
            height: 1px;
            background: rgba(255,255,255,0.07);
            margin: 22px 0;
        }

        /* Badge admin */
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            background: rgba(26,122,122,0.20);
            border: 1px solid rgba(26,122,122,0.35);
            color: #4dd9ac;
            margin-bottom: 14px;
        }

        .admin-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #4dd9ac;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.5; transform: scale(0.8); }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-card {
                padding: 28px 22px 24px;
                border-radius: 20px;
            }
            .logo-ring { width: 58px; height: 58px; }
            .login-title { font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="grid-overlay"></div>

    <div class="login-wrapper">

        {{-- Header --}}
        <div class="login-header">
            <div class="logo-ring">
                <svg width="30" height="30" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0M19.607 16.815A9.97 9.97 0 0122 12c0-5.523-4.477-10-10-10S2 6.477 2 12a9.97 9.97 0 002.393 6.815" />
                </svg>
            </div>
            <div class="login-title">Kantinku Admin</div>
            <div class="login-subtitle">Halaman Administrator</div>
        </div>

        {{-- Card --}}
        <div class="login-card">

            {{-- Admin badge --}}
            <div style="text-align:center; margin-bottom: 20px;">
                <span class="admin-badge">
                    <span class="admin-badge-dot"></span>
                    Administrator Access
                </span>
            </div>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="alert-error">
                    <ul style="list-style:disc; padding-left:16px; line-height:1.8;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="admin">

                {{-- Email --}}
                <div class="field-group">
                    <label class="field-label" for="email">Email</label>
                    <input
                        class="field-input"
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="admin@kantinku2.com"
                        required
                        autofocus
                    >
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <div class="password-wrap">
                        <input
                            class="field-input"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" class="toggle-pass" onclick="togglePassword()">
                            <svg id="eye-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember --}}
                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-submit">
                    Masuk sebagai Admin
                </button>

            </form>
        </div>

        {{-- Back link --}}
        <div class="back-link">
            <a href="{{ route('login') }}">Kembali ke halaman login</a>
        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.399-4.024M9.88 9.88A3 3 0 0112 9a3 3 0 013 3m0 0a3 3 0 01-3 3m-3-3H3m18 0h-3M3 3l18 18" />`;
            } else {
                input.type = 'password';
                icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>

</body>
</html>