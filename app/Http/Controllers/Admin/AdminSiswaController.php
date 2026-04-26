<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('kelas', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif' ? 1 : 0);
        }

        $siswa = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.siswa.index', compact('siswa'));
    }

    public function show($id)
    {
        $siswa = User::findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function toggle($id)
    {
        $siswa = User::findOrFail($id);
        $siswa->update(['is_active' => !$siswa->is_active]);

        $status = $siswa->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Akun {$siswa->nama_lengkap} berhasil {$status}.");
    }

    public function resetPassword($id)
    {
        $siswa = User::findOrFail($id);
        $newPassword = '12345678';
        $siswa->update(['password' => Hash::make($newPassword)]);

        return back()->with('success', "Password {$siswa->nama_lengkap} berhasil direset ke: {$newPassword}");
    }

    public function destroy($id)
    {
        $siswa = User::findOrFail($id);
        $nama  = $siswa->nama_lengkap;
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', "Akun siswa {$nama} berhasil dihapus.");
    }
}