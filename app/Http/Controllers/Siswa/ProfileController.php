<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $siswa = auth('web')->user();
        return view('siswa.profile', compact('siswa'));
    }

    public function update(Request $request)
    {
        $siswa = auth('web')->user();

        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'no_telepon'   => 'nullable|string|max:15',
        ];

        // Validasi password hanya jika diisi
        if ($request->filled('password')) {
            $rules['password']              = 'required|string|min:6|confirmed';
            $rules['password_confirmation'] = 'required';
        }

        $request->validate($rules, [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $siswa->nama_lengkap = $request->nama_lengkap;
        $siswa->no_telepon   = $request->no_telepon;

        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }

        $siswa->save();

        return redirect()->route('siswa.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}