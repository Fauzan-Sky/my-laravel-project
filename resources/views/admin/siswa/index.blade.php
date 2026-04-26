<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Siswa — Kantinku2</title>
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
                <span class="text-red-200 text-sm">/ Kelola Siswa</span>
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

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Kelola Siswa</h1>
                <p class="text-gray-500 text-sm mt-1">Total {{ $siswa->total() }} siswa terdaftar</p>
            </div>
            <a href="{{ route('admin.dashboard') }}"
                class="text-sm text-gray-500 hover:text-red-600 flex items-center gap-1 transition">
                ← Kembali ke Dashboard
            </a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filter & Search --}}
        <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Cari Siswa</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Nama, NIS, atau Kelas..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                    <select name="status"
                        class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                        <option value="">Semua</option>
                        <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <button type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition">
                    Cari
                </button>
                @if (request('search') || request('status'))
                    <a href="{{ route('admin.siswa.index') }}"
                        class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">No</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Nama Lengkap</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">NIS</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Kelas</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Status</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Terdaftar</th>
                        <th class="text-left px-6 py-3 text-gray-600 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($siswa as $index => $s)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-500">
                                {{ ($siswa->currentPage() - 1) * $siswa->perPage() + $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $s->nama_lengkap }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $s->nis }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $s->kelas }}</td>
                            <td class="px-6 py-4">
                                @if ($s->is_active)
                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-medium">Aktif</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-medium">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ \Carbon\Carbon::parse($s->created_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">

                                    {{-- Detail --}}
                                    <a href="{{ route('admin.siswa.show', $s->id) }}"
                                        class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1 rounded-lg text-xs font-medium transition">
                                        Detail
                                    </a>

                                    {{-- Toggle Aktif/Nonaktif --}}
                                    <form action="{{ route('admin.siswa.toggle', $s->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="{{ $s->is_active ? 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }} px-3 py-1 rounded-lg text-xs font-medium transition">
                                            {{ $s->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    {{-- Reset Password --}}
                                    <form action="{{ route('admin.siswa.resetPassword', $s->id) }}" method="POST"
                                        onsubmit="return confirm('Reset password {{ $s->nama_lengkap }} ke 12345678?')">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="bg-purple-50 text-purple-600 hover:bg-purple-100 px-3 py-1 rounded-lg text-xs font-medium transition">
                                            Reset PW
                                        </button>
                                    </form>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus akun {{ $s->nama_lengkap }}? Tindakan ini tidak bisa dibatalkan!')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1 rounded-lg text-xs font-medium transition">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                Tidak ada data siswa ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($siswa->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $siswa->links() }}
                </div>
            @endif
        </div>

    </div>

</body>
</html>