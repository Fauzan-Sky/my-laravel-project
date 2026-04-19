<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Menu – {{ $kantin->nama_kantinn }} – KantinKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal:       #1B6B7B;
            --teal-dark:  #155d6c;
            --teal-light: #e8f4f6;
            --text:       #1a1a1a;
            --muted:      #888;
            --border:     #e8e8e8;
            --bg:         #f4f7f8;
            --white:      #ffffff;
            --success:    #27ae60;
            --danger:     #e74c3c;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }

        /* NAVBAR */
        .navbar { background:var(--white); border-bottom:1px solid var(--border); position:sticky; top:0; z-index:200; box-shadow:0 1px 12px rgba(0,0,0,0.06); }
        .navbar-inner { max-width:1300px; margin:0 auto; padding:0 32px; height:64px; display:flex; align-items:center; justify-content:space-between; gap:20px; }
        .navbar-brand { display:flex; align-items:center; gap:10px; text-decoration:none; flex-shrink:0; }
        .brand-text { font-size:20px; font-weight:800; color:var(--teal); }
        .brand-text span { color:var(--text); }
        .navbar-kantin { display:flex; align-items:center; gap:6px; font-size:14px; color:var(--muted); }
        .navbar-kantin strong { color:var(--text); font-weight:700; }
        .back-btn { display:flex; align-items:center; gap:8px; padding:8px 16px; border-radius:10px; border:1.5px solid var(--border); background:transparent; font-family:'Poppins',sans-serif; font-size:13px; font-weight:600; color:var(--muted); cursor:pointer; text-decoration:none; transition:all 0.2s; flex-shrink:0; }
        .back-btn:hover { border-color:var(--teal); color:var(--teal); }

        /* LAYOUT */
        .layout { max-width:1300px; margin:0 auto; padding:28px 32px; display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start; }

        /* TOOLBAR */
        .toolbar { display:flex; gap:12px; margin-bottom:20px; align-items:center; }
        .search-wrap { flex:1; position:relative; }
        .search-wrap svg { position:absolute; left:12px; top:50%; transform:translateY(-50%); stroke:var(--muted); pointer-events:none; }
        .search-input { width:100%; padding:10px 14px 10px 38px; border:1.5px solid var(--border); border-radius:10px; font-family:'Poppins',sans-serif; font-size:14px; color:var(--text); background:var(--white); outline:none; transition:border-color 0.2s; }
        .search-input:focus { border-color:var(--teal); }
        .search-input::placeholder { color:#bbb; }

        /* FILTER */
        .filter-bar { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; }
        .filter-btn { padding:7px 16px; border-radius:100px; border:1.5px solid var(--border); background:var(--white); font-family:'Poppins',sans-serif; font-size:12px; font-weight:600; color:var(--muted); cursor:pointer; transition:all 0.2s; text-transform:capitalize; }
        .filter-btn:hover { border-color:var(--teal); color:var(--teal); }
        .filter-btn.active { background:var(--teal); border-color:var(--teal); color:#fff; }

        /* MENU GRID */
        .menu-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:16px; }
        .menu-card { background:var(--white); border-radius:16px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,0.05); transition:all 0.2s; border:2px solid transparent; }
        .menu-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.09); }
        .menu-card.in-cart { border-color:var(--teal); }
        .menu-card.unavailable { opacity:0.5; }
        .menu-thumb { height:130px; background:linear-gradient(135deg, var(--teal-light) 0%, #c8e8ed 100%); display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden; }
        .menu-thumb img { width:100%; height:100%; object-fit:cover; }
        .menu-thumb svg { stroke:var(--teal); opacity:0.4; }
        .menu-stok-badge { position:absolute; bottom:8px; right:8px; background:rgba(0,0,0,0.55); color:#fff; font-size:10px; font-weight:600; padding:3px 8px; border-radius:6px; }
        .menu-stok-badge.low { background:rgba(231,76,60,0.85); }
        .menu-body { padding:14px; }
        .menu-kategori { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:var(--teal); margin-bottom:4px; }
        .menu-name  { font-size:14px; font-weight:700; color:var(--text); margin-bottom:4px; line-height:1.3; }
        .menu-harga { font-size:15px; font-weight:800; color:var(--teal); margin-bottom:12px; }

        /* QTY */
        .qty-control { display:flex; align-items:center; border:1.5px solid var(--border); border-radius:10px; overflow:hidden; }
        .qty-btn { width:34px; height:34px; border:none; background:#f8f8f8; cursor:pointer; font-size:16px; font-weight:700; color:var(--teal); transition:background 0.15s; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .qty-btn:hover { background:var(--teal-light); }
        .qty-val { flex:1; text-align:center; font-size:14px; font-weight:700; color:var(--text); min-width:32px; }
        .btn-add { width:100%; padding:9px; border:none; border-radius:10px; background:var(--teal); color:#fff; font-family:'Poppins',sans-serif; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:6px; }
        .btn-add:hover { background:var(--teal-dark); }
        .btn-add:disabled { background:#ccc; cursor:not-allowed; }
        .empty-menu { grid-column:1/-1; text-align:center; padding:48px; color:var(--muted); }
        .empty-menu svg { stroke:#ccc; margin-bottom:10px; }
        .empty-menu p { font-size:14px; font-weight:600; color:#666; }

        /* KERANJANG */
        .cart-sidebar { position:sticky; top:88px; }
        .cart-card { background:var(--white); border-radius:20px; box-shadow:0 4px 24px rgba(0,0,0,0.08); overflow:hidden; }
        .cart-header { padding:18px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .cart-title { font-size:15px; font-weight:700; display:flex; align-items:center; gap:8px; }
        .cart-title svg { stroke:var(--teal); }
        .cart-count { background:var(--teal); color:#fff; font-size:11px; font-weight:700; width:20px; height:20px; border-radius:50%; display:flex; align-items:center; justify-content:center; }
        .cart-items { max-height:320px; overflow-y:auto; padding:8px 0; }
        .cart-items::-webkit-scrollbar { width:4px; }
        .cart-items::-webkit-scrollbar-thumb { background:var(--border); border-radius:4px; }
        .cart-item { display:flex; align-items:center; gap:10px; padding:10px 20px; transition:background 0.15s; }
        .cart-item:hover { background:var(--bg); }
        .cart-item-info { flex:1; min-width:0; }
        .cart-item-name { font-size:13px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .cart-item-price { font-size:12px; color:var(--muted); margin-top:1px; }
        .cart-item-subtotal { font-size:13px; font-weight:700; color:var(--teal); flex-shrink:0; }
        .cart-remove { background:none; border:none; cursor:pointer; color:#ccc; padding:2px; transition:color 0.15s; display:flex; }
        .cart-remove:hover { color:var(--danger); }
        .cart-empty { padding:32px 20px; text-align:center; color:var(--muted); }
        .cart-empty svg { stroke:#ddd; margin-bottom:8px; }
        .cart-empty p { font-size:13px; }
        .cart-footer { padding:16px 20px; border-top:1px solid var(--border); }
        .cart-total-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; }
        .cart-total-label { font-size:13px; color:var(--muted); font-weight:500; }
        .cart-total-value { font-size:18px; font-weight:800; color:var(--teal); }
        .btn-checkout { width:100%; padding:13px; border:none; border-radius:12px; background:var(--teal); color:#fff; font-family:'Poppins',sans-serif; font-size:14px; font-weight:700; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px; }
        .btn-checkout:hover { background:var(--teal-dark); transform:translateY(-1px); box-shadow:0 6px 20px rgba(27,107,123,0.3); }
        .btn-checkout:disabled { background:#ccc; cursor:not-allowed; transform:none; box-shadow:none; }
        .btn-clear { width:100%; padding:8px; border:1.5px solid var(--border); border-radius:10px; background:transparent; font-family:'Poppins',sans-serif; font-size:12px; font-weight:600; color:var(--muted); cursor:pointer; margin-top:8px; transition:all 0.2s; }
        .btn-clear:hover { border-color:var(--danger); color:var(--danger); }

        /* MODAL */
        .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:500; display:none; align-items:center; justify-content:center; padding:20px; }
        .modal-overlay.open { display:flex; }
        .modal { background:var(--white); border-radius:20px; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.2); overflow:hidden; }
        .modal-header { padding:20px 24px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
        .modal-title { font-size:16px; font-weight:800; }
        .modal-close { background:none; border:none; cursor:pointer; color:var(--muted); display:flex; transition:color 0.15s; }
        .modal-close:hover { color:var(--text); }
        .modal-body { padding:20px 24px; }
        .modal-section-title { font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:0.8px; color:var(--muted); margin-bottom:10px; }
        .modal-order-item { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #f5f5f5; font-size:13px; }
        .modal-order-item:last-child { border-bottom:none; }
        .modal-order-name { font-weight:500; }
        .modal-order-qty  { color:var(--muted); margin:0 8px; }
        .modal-order-sub  { font-weight:700; color:var(--teal); }
        .modal-total { display:flex; justify-content:space-between; align-items:center; padding:14px 0 0; border-top:2px solid var(--border); font-size:15px; font-weight:800; margin-bottom:16px; }
        .modal-total span:last-child { color:var(--teal); }
        .catatan-input { width:100%; padding:10px 14px; border:1.5px solid var(--border); border-radius:10px; font-family:'Poppins',sans-serif; font-size:13px; color:var(--text); outline:none; resize:none; transition:border-color 0.2s; }
        .catatan-input:focus { border-color:var(--teal); }
        .catatan-input::placeholder { color:#bbb; }
        .modal-footer { padding:16px 24px; border-top:1px solid var(--border); display:flex; gap:10px; }
        .btn-cancel  { flex:1; padding:12px; border:1.5px solid var(--border); border-radius:12px; background:transparent; font-family:'Poppins',sans-serif; font-size:14px; font-weight:600; color:var(--muted); cursor:pointer; transition:all 0.2s; }
        .btn-cancel:hover { border-color:var(--teal); color:var(--teal); }
        .btn-confirm { flex:2; padding:12px; border:none; border-radius:12px; background:var(--teal); color:#fff; font-family:'Poppins',sans-serif; font-size:14px; font-weight:700; cursor:pointer; transition:all 0.2s; }
        .btn-confirm:hover { background:var(--teal-dark); }
        .btn-confirm:disabled { background:#ccc; cursor:not-allowed; }

        /* MODAL ANTREAN */
        .antrean-modal { text-align:center; padding:32px 24px; }
        .antrean-icon { width:72px; height:72px; background:var(--teal-light); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
        .antrean-icon svg { stroke:var(--teal); }
        .antrean-label  { font-size:13px; color:var(--muted); margin-bottom:6px; }
        .antrean-number { font-size:56px; font-weight:800; color:var(--teal); line-height:1; margin-bottom:8px; }
        .antrean-kantin { font-size:14px; color:var(--muted); margin-bottom:24px; }
        .btn-selesai { padding:13px 32px; border:none; border-radius:12px; background:var(--teal); color:#fff; font-family:'Poppins',sans-serif; font-size:15px; font-weight:700; cursor:pointer; transition:all 0.2s; text-decoration:none; display:inline-block; }
        .btn-selesai:hover { background:var(--teal-dark); }

        .alert { padding:13px 18px; border-radius:12px; font-size:13px; margin-bottom:20px; font-weight:500; }
        .alert-danger { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }

        /* SLOT WAKTU */
        .slot-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:20px; }
        .slot-card { border:2px solid var(--border); border-radius:12px; padding:14px 16px; cursor:pointer; transition:all 0.2s; background:var(--white); }
        .slot-card:hover { border-color:var(--teal); }
        .slot-card.selected { border-color:var(--teal); background:var(--teal-light); }
        .slot-label { font-size:13px; font-weight:700; color:var(--text); margin-bottom:4px; }
        .slot-time  { font-size:12px; color:var(--muted); }
        .slot-sisa  { font-size:11px; font-weight:600; margin-top:4px; }
        .slot-sisa.aman  { color:var(--success); }
        .slot-sisa.habis { color:var(--danger); }

        /* PEMBAYARAN */
        .bayar-option { border:2px solid var(--border); border-radius:12px; padding:14px 16px; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; gap:12px; margin-bottom:10px; }
        .bayar-option:hover { border-color:var(--teal); }
        .bayar-option.selected { border-color:var(--teal); background:var(--teal-light); }
        .bayar-icon { width:40px; height:40px; background:var(--teal-light); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .bayar-icon svg { stroke:var(--teal); }
        .bayar-name { font-size:14px; font-weight:700; color:var(--text); }
        .bayar-desc { font-size:12px; color:var(--muted); }

        /* INVOICE */
        .invoice-box { background:var(--bg); border-radius:14px; padding:20px; margin-bottom:20px; }
        .invoice-header { text-align:center; margin-bottom:16px; padding-bottom:16px; border-bottom:1px dashed var(--border); }
        .invoice-logo { font-size:18px; font-weight:800; color:var(--teal); }
        .invoice-sub  { font-size:12px; color:var(--muted); margin-top:2px; }
        .invoice-antrean { font-size:48px; font-weight:800; color:var(--teal); text-align:center; margin:8px 0; line-height:1; }
        .invoice-antrean-label { font-size:12px; color:var(--muted); text-align:center; margin-bottom:16px; }
        .invoice-row { display:flex; justify-content:space-between; font-size:13px; padding:5px 0; }
        .invoice-row .label { color:var(--muted); }
        .invoice-row .val   { font-weight:600; }
        .invoice-divider { border:none; border-top:1px dashed var(--border); margin:10px 0; }
        .invoice-total { display:flex; justify-content:space-between; font-size:15px; font-weight:800; padding-top:8px; }
        .invoice-total .val { color:var(--teal); }
        .invoice-items { margin:10px 0; }
        .invoice-item { display:flex; justify-content:space-between; font-size:12px; padding:3px 0; }

        @media (max-width:900px) {
            .layout { grid-template-columns:1fr; padding-bottom:240px; }
            .cart-sidebar { position:fixed; bottom:0; left:0; right:0; top:auto; z-index:300; }
            .cart-card { border-radius:20px 20px 0 0; }
        }
        @media (max-width:500px) {
            .layout { padding:20px 16px; }
            .navbar-inner { padding:0 16px; }
            .menu-grid { grid-template-columns:1fr 1fr; }
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
        <div class="navbar-kantin">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/>
                <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
            </svg>
            <strong>{{ $kantin->nama_kantinn }}</strong>
        </div>
        <a href="{{ route('siswa.dashboard') }}" class="back-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>
    </div>
</nav>

<div class="layout">

    {{-- KIRI: MENU --}}
    <div>
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="toolbar">
            <div class="search-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" class="search-input" id="searchInput" placeholder="Cari menu..." oninput="filterMenu()">
            </div>
        </div>

        <div class="filter-bar" id="filterBar">
            <button class="filter-btn active" data-kategori="semua">Semua</button>
            @foreach($kategoriList as $kat)
                <button class="filter-btn" data-kategori="{{ $kat }}">{{ ucfirst($kat) }}</button>
            @endforeach
        </div>

        <div class="menu-grid" id="menuGrid">
            @forelse($menuList as $menu)
            <div class="menu-card {{ !$menu->is_available || $menu->stok <= 0 ? 'unavailable' : '' }}"
                 data-nama="{{ strtolower($menu->nama_menu) }}"
                 data-kategori="{{ $menu->kategori }}"
                 data-id="{{ $menu->id }}">

                <div class="menu-thumb">
                    @if($menu->foto)
                        <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}">
                    @else
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/>
                            <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
                        </svg>
                    @endif
                    @if($menu->is_available && $menu->stok > 0)
                        <span class="menu-stok-badge {{ $menu->stok <= 5 ? 'low' : '' }}">Stok: {{ $menu->stok }}</span>
                    @else
                        <span class="menu-stok-badge low">Habis</span>
                    @endif
                </div>

                <div class="menu-body">
                    <div class="menu-kategori">{{ $menu->kategori ?? 'Lainnya' }}</div>
                    <div class="menu-name">{{ $menu->nama_menu }}</div>
                    <div class="menu-harga">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>

                    @if($menu->is_available && $menu->stok > 0)
                        <div class="qty-control" id="qty-ctrl-{{ $menu->id }}" style="display:none">
                            <button class="qty-btn" data-id="{{ $menu->id }}" data-delta="-1" data-action="qty">−</button>
                            <span class="qty-val" id="qty-val-{{ $menu->id }}">0</span>
                            <button class="qty-btn" data-id="{{ $menu->id }}" data-delta="1" data-stok="{{ $menu->stok }}" data-action="qty">+</button>
                        </div>
                        <button class="btn-add" id="btn-add-{{ $menu->id }}"
                                data-id="{{ $menu->id }}"
                                data-nama="{{ addslashes($menu->nama_menu) }}"
                                data-harga="{{ $menu->harga }}"
                                data-stok="{{ $menu->stok }}"
                                data-action="add">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Tambah
                        </button>
                    @else
                        <button class="btn-add" disabled>Stok Habis</button>
                    @endif
                </div>
            </div>
            @empty
            <div class="empty-menu">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/>
                    <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3zm0 0v7"/>
                </svg>
                <p>Belum ada menu tersedia</p>
            </div>
            @endforelse
        </div>
    </div>

    {{-- KANAN: KERANJANG --}}
    <div class="cart-sidebar">
        <div class="cart-card">
            <div class="cart-header">
                <div class="cart-title">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    Keranjang
                    <span class="cart-count" id="cartCount">0</span>
                </div>
            </div>
            <div class="cart-items" id="cartItems">
                <div class="cart-empty" id="cartEmpty">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <p>Keranjang masih kosong</p>
                </div>
            </div>
            <div class="cart-footer">
                <div class="cart-total-row">
                    <span class="cart-total-label">Total</span>
                    <span class="cart-total-value" id="cartTotal">Rp 0</span>
                </div>
                <button class="btn-checkout" id="btnCheckout" disabled onclick="openCheckout()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Pesan Sekarang
                </button>
                <button class="btn-clear" id="btnClear" style="display:none" onclick="clearCart()">Kosongkan Keranjang</button>
            </div>
        </div>
    </div>

</div>

{{-- MODAL CHECKOUT: STEP 1 - Rincian + Slot + Bayar --}}
<div class="modal-overlay" id="checkoutModal">
    <div class="modal" style="max-width:520px">
        <div class="modal-header">
            <div class="modal-title">Checkout Pesanan</div>
            <button class="modal-close" onclick="closeCheckout()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <div class="modal-body" style="max-height:70vh; overflow-y:auto;">

            {{-- Rincian Pesanan --}}
            <div class="modal-section-title">Rincian Pesanan</div>
            <div id="modalOrderList"></div>
            <div class="modal-total" style="margin-bottom:20px">
                <span>Total Pembayaran</span>
                <span id="modalTotal">Rp 0</span>
            </div>

            {{-- Catatan --}}
            <div class="modal-section-title">Catatan (Opsional)</div>
            <textarea class="catatan-input" id="catatanInput" rows="2"
                      placeholder="Contoh: tidak pedas, tanpa bawang..." style="margin-bottom:20px"></textarea>

            {{-- Pilih Slot Waktu --}}
            <div class="modal-section-title">Pilih Jadwal Pengambilan</div>
            <div class="slot-grid" id="slotGrid">
                @foreach($slotList as $slot)
                <div class="slot-card {{ !$slot->is_active ? 'disabled' : '' }}"
                     data-slot-id="{{ $slot->id }}"
                     onclick="pilihSlot({{ $slot->id }}, this)">
                    <div class="slot-label">{{ $slot->label_slot }}</div>
                    <div class="slot-time">
                        {{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }} –
                        {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}
                    </div>
                    <div class="slot-sisa aman">Tersedia</div>
                </div>
                @endforeach
            </div>

            {{-- Metode Pembayaran --}}
            <div class="modal-section-title">Metode Pembayaran</div>
            <div class="bayar-option selected" id="bayarTunai" onclick="pilihBayar('tunai', this)">
                <div class="bayar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="6" width="20" height="12" rx="2"/>
                        <circle cx="12" cy="12" r="2"/>
                        <path d="M6 12h.01M18 12h.01"/>
                    </svg>
                </div>
                <div>
                    <div class="bayar-name">Uang Tunai</div>
                    <div class="bayar-desc">Bayar langsung saat mengambil pesanan</div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeCheckout()">Batal</button>
            <button class="btn-confirm" id="btnConfirm" onclick="submitOrder()">Buat Pesanan</button>
        </div>
    </div>
</div>

{{-- MODAL INVOICE --}}
<div class="modal-overlay" id="invoiceModal">
    <div class="modal" style="max-width:420px">
        <div class="modal-header">
            <div class="modal-title">Invoice Pesanan</div>
        </div>
        <div class="modal-body">
            <div class="invoice-box">
                <div class="invoice-header">
                    <div class="invoice-logo">KantinKu</div>
                    <div class="invoice-sub">{{ $kantin->nama_kantinn }}</div>
                </div>
                <div class="invoice-antrean" id="invAntrean">#001</div>
                <div class="invoice-antrean-label">Nomor Antrean Kamu</div>

                <div class="invoice-row">
                    <span class="label">Nama</span>
                    <span class="val">{{ auth('web')->user()->nama_lengkap }}</span>
                </div>
                <div class="invoice-row">
                    <span class="label">Jadwal</span>
                    <span class="val" id="invSlot">-</span>
                </div>
                <div class="invoice-row">
                    <span class="label">Pembayaran</span>
                    <span class="val">Uang Tunai</span>
                </div>

                <hr class="invoice-divider">

                <div class="invoice-items" id="invItems"></div>

                <hr class="invoice-divider">

                <div class="invoice-total">
                    <span>Total</span>
                    <span class="val" id="invTotal">Rp 0</span>
                </div>
            </div>
            <p style="font-size:12px; color:var(--muted); text-align:center; line-height:1.6;">
                Tunjukkan nomor antrean ini kepada penjual saat mengambil pesanan. Bayar langsung di kantin.
            </p>
        </div>
        <div class="modal-footer">
            <a href="{{ route('siswa.dashboard') }}" class="btn-confirm" style="text-decoration:none; text-align:center;">
                Selesai & Lihat Status
            </a>
        </div>
    </div>
</div>

{{-- Form tersembunyi --}}
<form method="POST" action="{{ route('siswa.pesanan.store') }}" id="orderForm" style="display:none">
    @csrf
    <input type="hidden" name="kantin_id" value="{{ $kantin->id }}">
    <input type="hidden" name="items" id="formItems">
    <input type="hidden" name="catatan" id="formCatatan">
    <input type="hidden" name="total_harga" id="formTotal">
    <input type="hidden" name="slot_id" id="formSlot">
    <input type="hidden" name="metode_bayar" value="tunai">
</form>

<script>
    let cart = {};
    let activeKategori = 'semua';
    let selectedSlotId = null;
    let selectedSlotLabel = '-';
    let selectedBayar = 'tunai';

    document.addEventListener('click', function(e) {
        const filterBtn = e.target.closest('.filter-btn');
        if (filterBtn) {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            filterBtn.classList.add('active');
            activeKategori = filterBtn.dataset.kategori;
            filterMenu();
            return;
        }

        const btn = e.target.closest('[data-action]');
        if (!btn) return;

        const action = btn.dataset.action;
        const id     = btn.dataset.id;

        if (action === 'add') {
            addToCart(id, btn.dataset.nama, parseFloat(btn.dataset.harga), parseInt(btn.dataset.stok));
        }

        if (action === 'qty') {
            changeQty(id, parseInt(btn.dataset.delta));
        }

        if (action === 'remove') {
            removeFromCart(id);
        }
    });

    function pilihSlot(id, el) {
        if (el.classList.contains('disabled')) return;
        document.querySelectorAll('.slot-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        selectedSlotId    = id;
        selectedSlotLabel = el.querySelector('.slot-label').textContent + ' (' + el.querySelector('.slot-time').textContent.trim() + ')';
    }

    function pilihBayar(metode, el) {
        document.querySelectorAll('.bayar-option').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        selectedBayar = metode;
    }

    function addToCart(id, nama, harga, stok) {
        cart[id] = { nama, harga, qty: 1, stok };
        document.getElementById('btn-add-' + id).style.display = 'none';
        document.getElementById('qty-ctrl-' + id).style.display = 'flex';
        document.getElementById('qty-val-' + id).textContent = 1;
        document.querySelector('.menu-card[data-id="' + id + '"]').classList.add('in-cart');
        renderCart();
    }

    function changeQty(id, delta) {
        if (!cart[id]) return;
        const newQty = cart[id].qty + delta;
        if (newQty <= 0) { removeFromCart(id); return; }
        if (newQty > cart[id].stok) return;
        cart[id].qty = newQty;
        document.getElementById('qty-val-' + id).textContent = newQty;
        renderCart();
    }

    function removeFromCart(id) {
        delete cart[id];
        document.getElementById('btn-add-' + id).style.display = 'flex';
        document.getElementById('qty-ctrl-' + id).style.display = 'none';
        document.getElementById('qty-val-' + id).textContent = 0;
        document.querySelector('.menu-card[data-id="' + id + '"]').classList.remove('in-cart');
        renderCart();
    }

    function clearCart() {
        Object.keys(cart).forEach(id => removeFromCart(id));
    }

    function renderCart() {
        const keys    = Object.keys(cart);
        const isEmpty = keys.length === 0;
        const total   = keys.reduce((sum, id) => sum + (cart[id].harga * cart[id].qty), 0);
        const count   = keys.reduce((sum, id) => sum + cart[id].qty, 0);

        document.getElementById('cartCount').textContent = count;
        document.getElementById('cartTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('btnCheckout').disabled = isEmpty;
        document.getElementById('btnClear').style.display = isEmpty ? 'none' : 'block';
        document.getElementById('cartEmpty').style.display = isEmpty ? 'block' : 'none';

        const container = document.getElementById('cartItems');
        container.querySelectorAll('.cart-item').forEach(el => el.remove());

        keys.forEach(id => {
            const item = cart[id];
            const sub  = item.harga * item.qty;
            const el   = document.createElement('div');
            el.className = 'cart-item';
            el.innerHTML = `
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.nama}</div>
                    <div class="cart-item-price">Rp ${item.harga.toLocaleString('id-ID')} × ${item.qty}</div>
                </div>
                <div class="cart-item-subtotal">Rp ${sub.toLocaleString('id-ID')}</div>
                <button class="cart-remove" data-action="remove" data-id="${id}">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            `;
            container.appendChild(el);
        });
    }

    function filterMenu() {
        const q = document.getElementById('searchInput').value.toLowerCase();
        document.querySelectorAll('.menu-card').forEach(card => {
            const matchSearch   = card.dataset.nama.includes(q);
            const matchKategori = activeKategori === 'semua' || card.dataset.kategori === activeKategori;
            card.style.display  = (matchSearch && matchKategori) ? '' : 'none';
        });
    }

    function openCheckout() {
        const keys  = Object.keys(cart);
        const total = keys.reduce((sum, id) => sum + (cart[id].harga * cart[id].qty), 0);

        document.getElementById('modalOrderList').innerHTML = keys.map(id => {
            const item = cart[id];
            return `<div class="modal-order-item">
                <span class="modal-order-name">${item.nama}</span>
                <span class="modal-order-qty">×${item.qty}</span>
                <span class="modal-order-sub">Rp ${(item.harga * item.qty).toLocaleString('id-ID')}</span>
            </div>`;
        }).join('');

        document.getElementById('modalTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('checkoutModal').classList.add('open');
    }

    function closeCheckout() {
        document.getElementById('checkoutModal').classList.remove('open');
    }

    function submitOrder() {
        if (!selectedSlotId) {
            alert('Pilih jadwal pengambilan terlebih dahulu.');
            return;
        }

        const keys  = Object.keys(cart);
        const total = keys.reduce((sum, id) => sum + (cart[id].harga * cart[id].qty), 0);
        const items = keys.map(id => ({
            menu_id:      parseInt(id),
            jumlah:       cart[id].qty,
            harga_satuan: cart[id].harga,
            subtotal:     cart[id].harga * cart[id].qty
        }));

        document.getElementById('formItems').value   = JSON.stringify(items);
        document.getElementById('formCatatan').value = document.getElementById('catatanInput').value;
        document.getElementById('formTotal').value   = total;
        document.getElementById('formSlot').value    = selectedSlotId;

        const btnConfirm = document.getElementById('btnConfirm');
        btnConfirm.disabled    = true;
        btnConfirm.textContent = 'Memproses...';

        const form = document.getElementById('orderForm');

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                closeCheckout();

                // Isi invoice
                document.getElementById('invAntrean').textContent = '#' + String(res.nomor_antrean).padStart(3, '0');
                document.getElementById('invSlot').textContent    = selectedSlotLabel;
                document.getElementById('invTotal').textContent   = 'Rp ' + total.toLocaleString('id-ID');
                document.getElementById('invItems').innerHTML     = keys.map(id => {
                    const item = cart[id];
                    return `<div class="invoice-item">
                        <span class="name">${item.nama} ×${item.qty}</span>
                        <span class="price">Rp ${(item.harga * item.qty).toLocaleString('id-ID')}</span>
                    </div>`;
                }).join('');

                document.getElementById('invoiceModal').classList.add('open');
            } else {
                alert(res.message || 'Terjadi kesalahan.');
                btnConfirm.disabled    = false;
                btnConfirm.textContent = 'Buat Pesanan';
            }
        })
        .catch(() => {
            alert('Gagal menghubungi server. Coba lagi.');
            btnConfirm.disabled    = false;
            btnConfirm.textContent = 'Buat Pesanan';
        });
    }
</script>

</body>
</html>