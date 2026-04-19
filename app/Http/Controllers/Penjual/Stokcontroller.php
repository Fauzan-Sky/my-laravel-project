<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StokController extends Controller
{
    // Update jumlah stok
    public function update(Request $request, $id)
    {
        $request->validate([
            'stok' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $penjual = Auth::guard('penjual')->user();

        $menu = Menu::where('id', $id)
            ->where('kantin_id', $penjual->kantin_id)
            ->firstOrFail();

        $menu->update(['stok' => $request->stok]);

        return back()->with('success', 'Stok "' . $menu->nama_menu . '" berhasil diperbarui menjadi ' . $request->stok . '.');
    }

    // Toggle ketersediaan menu (is_available)
    public function toggleAvailable(Request $request, $id)
    {
        $penjual = Auth::guard('penjual')->user();

        $menu = Menu::where('id', $id)
            ->where('kantin_id', $penjual->kantin_id)
            ->firstOrFail();

        $menu->update(['is_available' => $request->has('is_available')]);

        $status = $menu->is_available ? 'tersedia' : 'tidak tersedia';

        return back()->with('success', '"' . $menu->nama_menu . '" sekarang ' . $status . '.');
    }

    // Upload foto menu
    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'foto.required' => 'Pilih foto terlebih dahulu.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus jpg, jpeg, png, atau webp.',
            'foto.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        $penjual = Auth::guard('penjual')->user();

        $menu = Menu::where('id', $id)
            ->where('kantin_id', $penjual->kantin_id)
            ->firstOrFail();

        // Hapus foto lama kalau ada
        if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
            Storage::disk('public')->delete($menu->foto);
        }

        // Simpan foto baru
        $path = $request->file('foto')->store('menu', 'public');

        $menu->update(['foto' => $path]);

        return back()->with('success', 'Foto "' . $menu->nama_menu . '" berhasil diperbarui.');
    }
}