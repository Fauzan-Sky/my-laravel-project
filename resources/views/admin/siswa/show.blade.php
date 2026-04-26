<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa — Kantinku2</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-red-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                        </svg>
                    </div>
                    <span class="font-bold text-lg">Kantinku2</span>
                </a>
                <span class="text-red-200 text-sm">/ Kelola Siswa / Detail</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-red-100">👨‍💼 {{ Auth::guard('admin')->user()->name }}</span>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-white text-red-600 text-sm font-semibold px-4 py-1.5 rounded-lg hover:bg-red-50 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-6 py-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Detail Siswa</h1>
            <a href="{{ route('admin.siswa.index') }}"
                class="text-sm text-gray-500 hover:text-red-600 transition">← Kembali</a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

            {{-- Avatar --}}
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl font-bold text-blue-600">
                    {{ strtoupper(substr($siswa->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $siswa->nama_lengkap }}</h2>
                    <p class="text-gray-500 text-sm">{{ $siswa->kelas }}</p>
                </div>
                <div class="ml-auto">
                    @if ($siswa->is_active)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Aktif</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Nonaktif</span>
                    @endif
                </div>
            </div>

            {{-- Info --}}
            <table class="w-full text-sm text-gray-600">
                <tr class="border-b">
                    <td class="py-3 font-medium w-40">NIS</td>
                    <td class="py-3">{{ $siswa->nis }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-3 font-medium">Kelas</td>
                    <td class="py-3">{{ $siswa->kelas }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-3 font-medium">No. HP</td>
                    <td class="py-3">{{ $siswa->nomer_hp ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-3 font-medium">Status</td>
                    <td class="py-3">{{ $siswa->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-3 font-medium">Terdaftar</td>
                    <td class="py-3">{{ \Carbon\Carbon::parse($siswa->created_at)->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <td class="py-3 font-medium">Terakhir Update</td>
                    <td class="py-3">{{ \Carbon\Carbon::parse($siswa->updated_at)->format('d M Y, H:i') }}</td>
                </tr>
            </table>
        </div>

        {{-- Actions --}}
        <div class="flex flex-wrap gap-3">

            {{-- Toggle Aktif --}}
            <form action="{{ route('admin.siswa.toggle', $siswa->id) }}" method="POST">
                @csrf @method('PATCH')
                <button type="submit"
                    class="{{ $siswa->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-5 py-2 rounded-xl text-sm font-medium transition">
                    {{ $siswa->is_active ? '🔒 Nonaktifkan Akun' : '✅ Aktifkan Akun' }}
                </button>
            </form>

            {{-- Reset Password --}}
            <form action="{{ route('admin.siswa.resetPassword', $siswa->id) }}" method="POST"
                onsubmit="return confirm('Reset password ke 12345678?')">
                @csrf @method('PATCH')
                <button type="submit"
                    class="bg-purple-500 hover:bg-purple-600 text-white px-5 py-2 rounded-xl text-sm font-medium transition">
                    🔑 Reset Password
                </button>
            </form>

            {{-- Hapus --}}
            <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST"
                onsubmit="return confirm('Hapus akun ini? Tidak bisa dibatalkan!')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl text-sm font-medium transition">
                    🗑️ Hapus Akun
                </button>
            </form>

        </div>

    </div>

</body>
</html>