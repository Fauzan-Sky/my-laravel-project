<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Kantinku2</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">

    <div class="w-full max-w-md">

        {{-- Logo / Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-red-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0M19.607 16.815A9.97 9.97 0 0122 12c0-5.523-4.477-10-10-10S2 6.477 2 12a9.97 9.97 0 002.393 6.815" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Admin Panel</h1>
            <p class="text-gray-500 text-sm mt-1">Kantinku2 — Masuk sebagai Administrator</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-md p-8">

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="mb-5 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="admin">

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        placeholder="admin@kantinku2.com"
                        class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent
                               {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent pr-11
                                   {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                        >
                        {{-- Toggle show/hide password --}}
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        Ingat saya
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl transition duration-200 text-sm shadow">
                    Masuk sebagai Admin
                </button>

            </form>
        </div>

        {{-- Back link --}}
        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="{{ route('login') }}" class="hover:text-red-600 transition">
                ← Kembali ke halaman login
            </a>
        </p>

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