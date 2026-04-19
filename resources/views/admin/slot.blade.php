<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Slot Jadwal – Admin KantinKu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --teal: #1B6B7B; --teal-dark: #155d6c; --teal-light: #e8f4f6;
            --yellow: #FFE566; --danger: #e74c3c; --success: #27ae60;
            --text: #1a1a1a; --muted: #888; --border: #e8e8e8;
            --bg: #f4f7f8; --white: #ffffff; --sidebar-w: 240px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Poppins',sans-serif; background:var(--bg); display:flex; min-height:100vh; }

        /* SIDEBAR */
        .sidebar { width:var(--sidebar-w); background:var(--teal); min-height:100vh; position:fixed; display:flex; flex-direction:column; }
        .sidebar-brand { padding:28px 24px 20px; border-bottom:1px solid rgba(255,255,255,0.1); }
        .brand-name { font-size:22px; font-weight:800; color:var(--yellow); }
        .brand-sub  { font-size:12px; color:rgba(255,255,255,0.5); margin-top:2px; }
        .sidebar-nav { flex:1; padding:16px 0; }
        .nav-label { font-size:10px; font-weight:600; color:rgba(255,255,255,0.35); text-transform:uppercase; letter-spacing:1.2px; padding:12px 24px 6px; }
        .nav-item { display:flex; align-items:center; gap:12px; padding:11px 24px; color:rgba(255,255,255,0.65); font-size:14px; font-weight:500; text-decoration:none; border-left:3px solid transparent; transition:all 0.2s; }
        .nav-item:hover { background:rgba(255,255,255,0.07); color:#fff; }
        .nav-item.active { background:rgba(255,255,255,0.12); color:#fff; border-left-color:var(--yellow); font-weight:600; }
        .sidebar-footer { padding:16px 24px; border-top:1px solid rgba(255,255,255,0.1); }
        .btn-logout { width:100%; padding:10px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:10px; color:rgba(255,255,255,0.7); font-family:'Poppins',sans-serif; font-size:13px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s; }
        .btn-logout:hover { background:rgba(231,76,60,0.25); color:#ff8a8a; }

        /* MAIN */
        .main { margin-left:var(--sidebar-w); flex:1; padding:32px; }
        .page-header { margin-bottom:28px; }
        .page-title { font-size:22px; font-weight:800; }
        .page-subtitle { font-size:13px; color:var(--muted); margin-top:2px; }

        /* GRID */
        .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:24px; }

        /* CARD */
        .card { background:var(--white); border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.05); overflow:hidden; }
        .card-header { padding:18px 22px; border-bottom:1px solid var(--border); }
        .card-title { font-size:15px; font-weight:700; }
        .card-body { padding:22px; }

        /* FORM */
        .form-group { margin-bottom:16px; }
        .form-label { font-size:12px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:0.8px; margin-bottom:6px; display:block; }
        .form-input { width:100%; padding:10px 14px; border:1.5px solid var(--border); border-radius:10px; font-family:'Poppins',sans-serif; font-size:14px; color:var(--text); outline:none; transition:border-color 0.2s; }
        .form-input:focus { border-color:var(--teal); }
        .btn { padding:10px 20px; border-radius:10px; font-family:'Poppins',sans-serif; font-size:13px; font-weight:600; cursor:pointer; border:none; transition:all 0.2s; }
        .btn-teal { background:var(--teal); color:#fff; width:100%; padding:12px; }
        .btn-teal:hover { background:var(--teal-dark); }

        /* TABLE */
        table { width:100%; border-collapse:collapse; }
        thead th { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:0.8px; color:var(--muted); padding:10px 14px; background:#fafafa; text-align:left; border-bottom:1px solid var(--border); }
        tbody td { padding:14px; font-size:13px; border-bottom:1px solid #f0f0f0; }
        tbody tr:last-child td { border-bottom:none; }
        tbody tr:hover { background:#fafcfc; }

        /* BADGE */
        .badge { display:inline-flex; align-items:center; padding:4px 10px; border-radius:100px; font-size:11px; font-weight:600; }
        .badge-active   { background:#d4edda; color:#155724; }
        .badge-inactive { background:#f8d7da; color:#721c24; }

        /* TOGGLE */
        .toggle-switch { position:relative; width:40px; height:22px; }
        .toggle-switch input { display:none; }
        .toggle-slider { position:absolute; top:0; left:0; right:0; bottom:0; background:#ccc; border-radius:22px; cursor:pointer; transition:0.3s; }
        .toggle-slider::before { content:''; position:absolute; width:16px; height:16px; left:3px; top:3px; background:#fff; border-radius:50%; transition:0.3s; }
        .toggle-switch input:checked + .toggle-slider { background:var(--teal); }
        .toggle-switch input:checked + .toggle-slider::before { transform:translateX(18px); }

        /* ALERT */
        .alert { padding:12px 16px; border-radius:10px; font-size:13px; margin-bottom:20px; font-weight:500; }
        .alert-success { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
        .alert-danger  { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }

        .slot-time { font-size:13px; font-weight:700; color:var(--teal); }
        .slot-label { font-size:12px; color:var(--muted); margin-top:2px; }

        .btn-icon { padding:6px 12px; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; border:none; font-family:'Poppins',sans-serif; transition:all 0.2s; }
        .btn-danger { background:#fef0ee; color:var(--danger); }
        .btn-danger:hover { background:var(--danger); color:#fff; }

        .empty-state { text-align:center; padding:40px; color:var(--muted); }
        .empty-state p { font-size:14px; margin-top:10px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-name">KantinKu</div>
        <div class="brand-sub">Panel Admin</div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.slot.index') }}" class="nav-item active">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Slot Jadwal
        </a>
    </nav>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<main class="main">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="page-header">
        <div class="page-title">Kelola Slot Jadwal</div>
        <div class="page-subtitle">Atur waktu pengambilan pesanan untuk semua kantin</div>
    </div>

    <div class="grid-2">

        {{-- FORM TAMBAH SLOT --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tambah Slot Baru</div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.slot.store') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Slot</label>
                        <input type="text" name="label_slot" class="form-input"
                               placeholder="Contoh: Istirahat 1"
                               value="{{ old('label_slot') }}" required>
                        @error('label_slot')
                            <div style="font-size:12px; color:var(--danger); margin-top:4px">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-input"
                               value="{{ old('jam_mulai', '09:10') }}" required>
                        @error('jam_mulai')
                            <div style="font-size:12px; color:var(--danger); margin-top:4px">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-input"
                               value="{{ old('jam_selesai', '09:30') }}" required>
                        @error('jam_selesai')
                            <div style="font-size:12px; color:var(--danger); margin-top:4px">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-teal">Tambah Slot</button>
                </form>
            </div>
        </div>

        {{-- DAFTAR SLOT --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Daftar Slot Jadwal</div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nama Slot</th>
                        <th>Waktu</th>
                        <th>Aktif</th>
                        <th>Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slotList as $slot)
                    <tr>
                        <td style="font-weight:600">{{ $slot->label_slot }}</td>
                        <td>
                            <div class="slot-time">
                                {{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}
                            </div>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.slot.toggle', $slot->id) }}">
                                @csrf @method('PATCH')
                                <label class="toggle-switch">
                                    <input type="checkbox" {{ $slot->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                                    <span class="toggle-slider"></span>
                                </label>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.slot.destroy', $slot->id) }}"
                                  onsubmit="return confirm('Hapus slot ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                <p>Belum ada slot jadwal</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</main>

</body>
</html>