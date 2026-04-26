<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminMenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::with('penjual');

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->search) {
            $query->where('nama_menu', 'like', '%' . $request->search . '%');
        }

        $menus = $query->latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
            'kategori'  => 'required|in:makanan,minuman,snack',
            'foto'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_menu', 'deskripsi', 'harga', 'stok', 'kategori', 'kantin_id', 'penjual_id']);
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        Menu::create($data);
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
            'kategori'  => 'required|in:makanan,minuman,snack',
            'foto'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nama_menu', 'deskripsi', 'harga', 'stok', 'kategori']);
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        if ($request->hasFile('foto')) {
            if ($menu->foto) Storage::disk('public')->delete($menu->foto);
            $data['foto'] = $request->file('foto')->store('menu', 'public');
        }

        $menu->update($data);
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->foto) Storage::disk('public')->delete($menu->foto);
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}