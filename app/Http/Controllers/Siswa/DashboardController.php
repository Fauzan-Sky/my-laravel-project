<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kantin;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\SlotWaktu;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        $pesananTerbaru = Pesanan::with('kantin')
            ->where('user_id', $user->id)
            ->latest()->take(5)->get();

        $pesananAktifList = Pesanan::with(['kantin', 'detailPesanan.menu'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing', 'ready'])
            ->latest()->get();

        $riwayatPesanan = Pesanan::with(['kantin', 'detailPesanan.menu'])
            ->where('user_id', $user->id)
            ->latest()->get();

        $kantinList = Kantin::orderBy('nama_kantinn')->get();

        return view('siswa.dashboard', compact(
            'pesananTerbaru',
            'pesananAktifList',
            'riwayatPesanan',
            'kantinList'
        ));
    }

    public function pilihMenu($id)
    {
        $kantin = Kantin::findOrFail($id);

        if ($kantin->status_operasional === 'tutup') {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Kantin sedang tutup.');
        }

        $menuList     = Menu::where('kantin_id', $id)->orderBy('kategori')->get();
        $kategoriList = $menuList->pluck('kategori')->filter()->unique()->values()->toArray();

        // Fix: slot_waktu tidak punya kantin_id, ambil semua slot aktif
        $slotList = SlotWaktu::where('is_active', true)
                        ->orderBy('jam_mulai')
                        ->get();

        return view('siswa.pilih-menu', compact('kantin', 'menuList', 'kategoriList', 'slotList'));
    }
}