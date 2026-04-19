<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $penjual = Auth::guard('penjual')->user();

        // Kalau belum login, redirect ke halaman login penjual
        if (!$penjual) {
            return redirect()->route('login.penjual');
        }

        $kantinId = $penjual->kantin_id;
        $today    = Carbon::today();

        // Total pesanan hari ini
        $totalPesananHariIni = Pesanan::where('kantin_id', $kantinId)
            ->whereDate('created_at', $today)
            ->count();

        // Pendapatan harian (pesanan yang sudah diambil)
        $pendapatanHarian = Pesanan::where('kantin_id', $kantinId)
            ->whereDate('created_at', $today)
            ->where('status', 'picked')
            ->sum('total_harga');

        // Pesanan menunggu (pending)
        $pesananMenunggu = Pesanan::where('kantin_id', $kantinId)
            ->where('status', 'pending')
            ->count();

        // Pesanan selesai (picked) hari ini
        $pesananSelesai = Pesanan::where('kantin_id', $kantinId)
            ->whereDate('created_at', $today)
            ->where('status', 'picked')
            ->count();

        // 5 pesanan terbaru
        $pesananTerbaru = Pesanan::with('user')
            ->where('kantin_id', $kantinId)
            ->whereDate('created_at', $today)
            ->latest()
            ->take(5)
            ->get();

        // Stok menipis (stok <= 15)
        $stokMenipis = Menu::where('kantin_id', $kantinId)
            ->where('stok', '<=', 15)
            ->orderBy('stok')
            ->get();

        // Semua pesanan hari ini untuk tabel lengkap
        $semuaPesanan = Pesanan::with(['user', 'detailPesanan.menu'])
            ->where('kantin_id', $kantinId)
            ->whereDate('created_at', $today)
            ->latest()
            ->get();

        // Semua menu untuk manajemen stok
        $menuList = Menu::where('kantin_id', $kantinId)
            ->orderBy('nama_menu')
            ->get();

        return view('penjual.dashboard', compact(
            'totalPesananHariIni',
            'pendapatanHarian',
            'pesananMenunggu',
            'pesananSelesai',
            'pesananTerbaru',
            'stokMenipis',
            'semuaPesanan',
            'menuList'
        ));
    }
}