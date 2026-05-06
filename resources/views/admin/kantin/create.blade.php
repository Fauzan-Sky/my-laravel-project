@extends('layouts.admin')

@section('title', 'Tambah Kantin')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Kantin</h1>
    <p class="text-gray-500 text-sm mt-1">Isi data kantin baru</p>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kantin.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kantin</label>
            <input type="text" name="nama_kantinn" value="{{ old('nama_kantinn') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: Kantin Barokah">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
            <textarea name="lokasi" rows="2"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: Gedung A lantai 1">{{ old('lokasi') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-gray-400">(opsional)</span></label>
            <input type="text" name="deskripsi" value="{{ old('deskripsi') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contoh: Menjual makanan dan minuman">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Buka</label>
                <input type="time" name="jam_buka" value="{{ old('jam_buka') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Tutup</label>
                <input type="time" name="jam_tutup" value="{{ old('jam_tutup') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status Operasional</label>
            <select name="status_operasional"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="buka" {{ old('status_operasional') === 'buka' ? 'selected' : '' }}>Buka</option>
                <option value="tutup" {{ old('status_operasional') === 'tutup' ? 'selected' : '' }}>Tutup</option>
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm hover:bg-blue-700 font-medium">
                Simpan
            </button>
            <a href="{{ route('admin.kantin.index') }}"
                class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-200 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection