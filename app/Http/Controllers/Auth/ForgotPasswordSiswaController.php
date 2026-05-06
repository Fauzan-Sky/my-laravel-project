<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordSiswaController extends Controller
{
    // Halaman form verifikasi
    public function index()
    {
        return view('auth.forgot-password');
    }

    // Verifikasi NIS + nama lengkap
    public function verifikasi(Request $request)
    {
        $request->validate([
            'nis'          => 'required|string',
            'nama_lengkap' => 'required|string',
        ], [
            'nis.required'          => 'NIS wajib diisi.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        $user = User::where('nis', $request->nis)
                    ->where('role', 'siswa')
                    ->first();

        if (!$user || strtolower(trim($user->nama_lengkap)) !== strtolower(trim($request->nama_lengkap))) {
            return back()->withErrors([
                'verifikasi' => 'NIS atau nama lengkap tidak ditemukan.'
            ])->withInput();
        }

        // Simpan id user di session, lanjut ke form reset
        session(['reset_user_id' => $user->id]);

        return redirect()->route('forgot-password.index')->with('verified', true);
    }

    // Reset password baru
    public function reset(Request $request)
    {
        if (!session('reset_user_id')) {
            return redirect()->route('forgot-password.index')
                             ->withErrors(['verifikasi' => 'Sesi tidak valid, silakan ulangi.']);
        }

        $request->validate([
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::find(session('reset_user_id'));

        if (!$user) {
            return redirect()->route('forgot-password.index')
                             ->withErrors(['verifikasi' => 'User tidak ditemukan.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus session
        session()->forget('reset_user_id');

        return redirect()->route('login')
                         ->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}