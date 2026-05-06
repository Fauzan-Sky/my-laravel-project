<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Kantinku')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { display: flex; min-height: 100vh; }
        #sidebar {
            width: 250px;
            min-height: 100vh;
            background: #0f4c5c;
            color: white;
            flex-shrink: 0;
        }
        #sidebar .nav-link {
            color: #a8d5df;
            padding: 10px 20px;
            border-radius: 6px;
            margin: 2px 10px;
            font-size: 14px;
        }
        #sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        #sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.15);
            border-left: 3px solid white;
        }
        #sidebar .brand {
            padding: 20px;
            font-size: 1.2rem;
            font-weight: 700;
            color: #f5c842;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        #sidebar hr { border-color: rgba(255,255,255,0.1); margin: 8px 10px; }
        #main { flex: 1; display: flex; flex-direction: column; background: #f0f4f5; }
        #topbar { background: white; padding: 12px 24px; border-bottom: 1px solid #e2e8f0; }
        #content { padding: 24px; flex: 1; }
    </style>

    @stack('styles')
</head>
<body>

{{-- Sidebar --}}
<div id="sidebar">
    <div class="brand">Kantinku</div>
    <nav class="nav flex-column mt-2">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <a href="{{ route('admin.menus.index') }}"
           class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
            <i class="bi bi-journal-text me-2"></i> Menu
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag me-2"></i> Orders
        </a>
        <a href="{{ route('admin.siswa.index') }}"
           class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
            <i class="bi bi-people me-2"></i> Siswa
        </a>
        <a href="{{ route('admin.kantin.index') }}"
           class="nav-link {{ request()->routeIs('admin.kantin.*') ? 'active' : '' }}">
            <i class="bi bi-shop me-2"></i> Kantin
        </a>
        <a href="{{ route('admin.laporan') }}"
           class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
            <i class="bi bi-bar-chart me-2"></i> Laporan
        </a>
        <hr>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-start w-100" style="color: #a8d5df;">
                <i class="bi bi-box-arrow-left me-2"></i> Logout
            </button>
        </form>
    </nav>
</div>

{{-- Main Content --}}
<div id="main">
    <div id="topbar" class="d-flex justify-content-between align-items-center">
        <h6 class="mb-0" style="color: #0f4c5c; font-weight: 600;">@yield('title', 'Dashboard')</h6>
        <span class="text-muted small">{{ auth('admin')->user()->name ?? 'Admin' }}</span>
    </div>
    <div id="content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>