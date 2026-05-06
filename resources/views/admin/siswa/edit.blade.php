@extends('layouts.admin')

@section('title', 'Edit Siswa')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Edit Data Siswa</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $siswa->nama_lengkap }}</p>
    </div>
    <a href="{{ route('admin.siswa.index') }}"
       class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">
        ← Kembali
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-lg">
    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
            <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm
                   @error('nis') border-red-500 @enderror">
            @error('nis')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $siswa->nama_lengkap) }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm
                   @error('nama_lengkap') border-red-500 @enderror">
            @error('nama_lengkap')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
            <input type="text" name="kelas" value="{{ old('kelas', $siswa->kelas) }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm
                   @error('kelas') border-red-500 @enderror">
            @error('kelas')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">No. HP</label>
            <input type="text" name="nomer_hp" value="{{ old('nomer_hp', $siswa->nomer_hp) }}"
                   class="w-full border rounded-lg px-3 py-2 text-sm">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="is_active" class="w-full border rounded-lg px-3 py-2 text-sm">
                <option value="1" {{ $siswa->is_active ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ !$siswa->is_active ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.siswa.index') }}"
               class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection