<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kantin;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        // Stat cards
        $pesananAktif = Pesanan::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing', 'ready'])
            ->count();

        $totalPesanan = Pesanan::where('user_id', $user->id)->count();

        $pesananSelesai = Pesanan::where('user_id', $user->id)
            ->where('status', 'picked')
            ->count();

        // 5 pesanan terbaru untuk home
        $pesananTerbaru = Pesanan::with('kantin')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Pesanan aktif (belum diambil)
        $pesananAktifList = Pesanan::with(['kantin', 'detailPesanan.menu'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing', 'ready'])
            ->latest()
            ->get();

        // Riwayat (sudah diambil)
        $riwayatPesanan = Pesanan::with(['kantin', 'detailPesanan.menu'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Daftar kantin
        $kantinList = Kantin::orderBy('nama_kantinn')->get();

        return view('siswa.dashboard', compact(
            'pesananAktif',
            'totalPesanan',
            'pesananSelesai',
            'pesananTerbaru',
            'pesananAktifList',
            'riwayatPesanan',
            'kantinList'
        ));
    }
}