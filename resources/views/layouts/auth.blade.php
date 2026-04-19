<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KantinKu') &ndash; Sistem Manajemen Kantin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:      #FF6B35;
            --primary-dark: #e05520;
            --secondary:    #2D1B69;
            --accent:       #FFD23F;
            --success:      #06D6A0;
            --danger:       #EF476F;
            --bg:           #0F0A1E;
            --bg2:          #1A1033;
            --bg3:          #241540;
            --card:         rgba(255,255,255,0.04);
            --border:       rgba(255,255,255,0.08);
            --text:         #F0EBF8;
            --muted:        #8B7FAB;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            pointer-events: none; z-index: 0;
            background:
                radial-gradient(ellipse 60% 50% at 15% 10%, rgba(255,107,53,0.10) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 85% 85%, rgba(45,27,105,0.35) 0%, transparent 60%);
        }
    </style>

    {{-- Tiap halaman child bisa tambah CSS sendiri lewat @stack --}}
    @stack('styles')
</head>
<body>
    <div style="position: relative; z-index: 1;">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>