<?php
namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class StokController extends Controller
{
    /**
     * Tambah menu baru
     */
    public function store(Request $request)
    {
        $penjual = Auth::guard('penjual')->user();

        $validated = $request->validate([
            'nama_menu'    => ['required', 'string', 'max:100'],
            'kategori'     => ['required', Rule::in(['makanan', 'minuman'])],
            'harga'        => ['required', 'numeric', 'min:0', 'max:9999999'],
            'stok'         => ['required', 'integer', 'min:0', 'max:999'],
            'deskripsi'    => ['nullable', 'string', 'max:500'],
            'foto'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_available' => ['nullable', 'boolean'],
        ], [
            'nama_menu.required' => 'Nama menu wajib diisi.',
            'kategori.required'  => 'Kategori wajib dipilih.',
            'kategori.in'        => 'Kategori harus makanan atau minuman.',
            'harga.required'     => 'Harga wajib diisi.',
            'harga.numeric'      => 'Harga harus berupa angka.',
            'stok.required'      => 'Stok wajib diisi.',
            'stok.integer'       => 'Stok harus berupa angka bulat.',
            'foto.image'         => 'File harus berupa gambar.',
            'foto.mimes'         => 'Format foto: jpg, jpeg, png, atau webp.',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = [
            'kantin_id'    => $penjual->kantin_id,
            'penjual_id'   => $penjual->id,
            'nama_menu'    => $validated['nama_menu'],
            'kategori'     => $validated['kategori'],
            'harga'        => $validated['harga'],
            'stok'         => $validated['stok'],
            'deskripsi'    => $validated['deskripsi'] ?? null,
            'is_available' => $request->has('is_available'),
        ];

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu = Menu::create($data);

        return redirect()
            ->route('penjual.dashboard', ['#stok'])
            ->with('success', 'Menu "' . $menu->nama_menu . '" berhasil ditambahkan.');
    }

    /**
     * Edit menu (semua field)
     */
    public function editUpdate(Request $request, $id)
    {
        $penjual = Auth::guard('penjual')->user();

        $menu = Menu::where('id', $id)
            ->where('kantin_id', $penjual->kantin_id)
            ->firstOrFail();

        $validated = $request->validate([
            'nama_menu'    => ['required', 'string', 'max:100'],
            'kategori'     => ['required', Rule::in(['makanan', 'minuman'])],
            'harga'        => ['required', 'numeric', 'min:0', 'max:9999999'],
            'stok'         => ['required', 'integer', 'min:0', 'max:999'],
            'deskripsi'    => ['nullable', 'string', 'max:500'],
            'foto'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_available' => ['nullable', 'boolean'],
        ]);

        $data = [
            'nama_menu'    => $validated['nama_menu'],
            'kategori'     => $validated['kategori'],
            'harga'        => $validated['harga'],
            'stok'         => $validated['stok'],
            'deskripsi'    => $validated['deskripsi'] ?? null,
            'is_available' => $request->has('is_available'),
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
                Storage::disk('public')->delete($menu->foto);
            }
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()
            ->route('penjual.dashboard', ['#stok'])
            ->with('success', 'Menu "' . $menu->nama_menu . '" berhasil diperbarui.');
    }

    /**
     * Hapus menu
     */
    public function destroy($id)
    {
        $penjual = Auth::guard('penjual')->user();

        $menu = Menu::where('id', $id)
            ->where('kantin_id', $penjual->kantin_id)
            ->firstOrFail();

        // Cek apakah menu masih dipakai di pesanan aktif
        $adaPesananAktif = $menu->detailPesanan()
            ->whereHas('pesanan', function ($q) {
                $q->whereIn('status', ['pending', 'processing', 'ready']);
            })
            ->exists();

        if ($adaPesananAktif) {
            return redirect()
                ->route('penjual.dashboard', ['#stok'])
                ->with('error', 'Menu "' . $menu->nama_menu . '" tidak bisa dihapus karena masih ada pesanan aktif. Selesaikan pesanan dulu, atau matikan toggle "Tersedia" untuk menyembunyikannya.');
        }

        $namaMenu = $menu->nama_menu;

        // Hapus foto kalau ada
        if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
            Storage::disk('public')->delete($menu->foto);
        }

        $menu->delete();

        return redirect()
            ->route('penjual.dashboard', ['#stok'])
            ->with('success', 'Menu "' . $namaMenu . '" berhasil dihapus.');
    }

    // ===== METHOD EXISTING (jangan diubah) =====

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

        if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
            Storage::disk('public')->delete($menu->foto);
        }

        $path = $request->file('foto')->store('menu', 'public');
        $menu->update(['foto' => $path]);

        return back()->with('success', 'Foto "' . $menu->nama_menu . '" berhasil diperbarui.');
    }
}