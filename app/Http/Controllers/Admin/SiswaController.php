<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = User::where('role', 'siswa')
            ->withCount('pesanan')
            ->withSum('pesanan', 'total_harga')
            ->paginate(10);

        return view('admin.siswa.index', compact('siswa'));
    }

    public function show($id)
    {
        $siswa = User::where('role', 'siswa')
            ->withCount('orders')
            ->withSum('orders', 'total_harga')
            ->findOrFail($id);

        $riwayat = $siswa->orders()->latest()->take(10)->get();

        return view('admin.siswa.show', compact('siswa', 'riwayat'));
    }

    public function edit($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, $id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        $request->validate([
            'nis'          => 'required|unique:users,nis,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'kelas'        => 'required|string|max:50',
            'nomer_hp'     => 'nullable|string|max:20',
            'is_active'    => 'required|in:0,1',
        ]);

        $siswa->update($request->only([
            'nis', 'nama_lengkap', 'kelas', 'nomer_hp', 'is_active'
        ]));

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }

    // Toggle aktif / nonaktif
    public function toggle($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->update(['is_active' => !$siswa->is_active]);

        $status = $siswa->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.siswa.index')
            ->with('success', "Siswa berhasil {$status}!");
    }

    // Reset password ke NIS siswa
    public function resetPassword($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        $siswa->update(['password' => Hash::make($siswa->nis)]);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Password berhasil direset ke NIS siswa!');
    }
}