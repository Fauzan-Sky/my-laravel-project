<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Kantinku2</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-red-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm7 0a1 1 0 100-2 1 1 0 000 2z" />
                    </svg>
                </div>
                <span class="font-bold text-lg">Kantinku2</span>
                <span class="text-red-200 text-sm">/ Admin Panel</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-red-100">
                    👨‍💼 {{ Auth::guard('admin')->user()->nama }}
                </span>
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

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- Alert Success --}}
        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500 text-sm mt-1">
                Selamat datang kembali, {{ Auth::guard('admin')->user()->nama }} 👋
            </p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

            {{-- Total Siswa --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6 5.87a4 4 0 10-8 0m8 0H9m4-8a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Siswa</p>
                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\User::count() }}</p>
                </div>
            </div>

            {{-- Total Penjual --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Penjual</p>
                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Penjual::count() }}</p>
                </div>
            </div>

            {{-- Total Admin --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Admin</p>
                    <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Admin::count() }}</p>
                </div>
            </div>

            {{-- Role --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Role Kamu</p>
                    <p class="text-lg font-bold text-gray-800 capitalize">
                        {{ Auth::guard('admin')->user()->role }}
                    </p>
                </div>
            </div>

        </div>

        {{-- Info Akun --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">📋 Info Akun</h2>
            <table class="text-sm text-gray-600 w-full">
                <tr class="border-b">
                    <td class="py-3 font-medium w-40">Nama</td>
                    <td class="py-3">{{ Auth::guard('admin')->user()->nama }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-3 font-medium">Email</td>
                    <td class="py-3">{{ Auth::guard('admin')->user()->email }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-3 font-medium">Role</td>
                    <td class="py-3 capitalize">{{ Auth::guard('admin')->user()->role }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-3 font-medium">Status</td>
                    <td class="py-3">
                        @if (Auth::guard('admin')->user()->is_active)
                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs font-medium">
                                Aktif
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs font-medium">
                                Tidak Aktif
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="py-3 font-medium">Login Terakhir</td>
                    <td class="py-3">
                        {{ Auth::guard('admin')->user()->last_login
                            ? \Carbon\Carbon::parse(Auth::guard('admin')->user()->last_login)->locale('id')->diffForHumans()
                            : '-' }}
                    </td>
                </tr>
            </table>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">⚡ Quick Actions</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

                {{-- Kelola Siswa (DIPERBAIKI) --}}
                <a href="{{ route('admin.siswa.index') }}" class="flex flex-col items-center gap-2 p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition text-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6 5.87a4 4 0 10-8 0m8 0H9" />
                    </svg>
                    <span class="text-sm font-medium text-blue-700">Kelola Siswa</span>
                </a>

                {{-- Kelola Penjual --}}
                <a href="#" class="flex flex-col items-center gap-2 p-4 bg-orange-50 hover:bg-orange-100 rounded-xl transition text-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="text-sm font-medium text-orange-700">Kelola Penjual</span>
                </a>

                {{-- Kelola Transaksi --}}
                <a href="#" class="flex flex-col items-center gap-2 p-4 bg-green-50 hover:bg-green-100 rounded-xl transition text-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="text-sm font-medium text-green-700">Kelola Transaksi</span>
                </a>

                {{-- Pengaturan --}}
                <a href="#" class="flex flex-col items-center gap-2 p-4 bg-purple-50 hover:bg-purple-100 rounded-xl transition text-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-sm font-medium text-purple-700">Pengaturan</span>
                </a>

            </div>
        </div>

    </div>

</body>
</html>