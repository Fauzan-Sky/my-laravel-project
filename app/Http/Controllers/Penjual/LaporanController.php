<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $penjual = auth('penjual')->user();
        $kantin  = $penjual->kantin;

        if (!$kantin) {
            return redirect()->route('penjual.dashboard')
                ->with('error', 'Anda belum terhubung ke kantin manapun.');
        }

        // Filter periode
        $periode = $request->get('periode', 'hari');
        $startDate = match($periode) {
            'minggu' => Carbon::now()->startOfWeek(),
            'bulan'  => Carbon::now()->startOfMonth(),
            default  => Carbon::today(),
        };
        $endDate = Carbon::now();

        if ($request->filled('dari') && $request->filled('sampai')) {
            $startDate = Carbon::parse($request->dari)->startOfDay();
            $endDate   = Carbon::parse($request->sampai)->endOfDay();
            $periode   = 'custom';
        }

        $baseQuery = Pesanan::where('kantin_id', $kantin->id)
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Ringkasan
        $totalPesanan    = (clone $baseQuery)->count();
        $totalPendapatan = (clone $baseQuery)->where('status', 'picked')->sum('total_harga');
        $pesananSelesai  = (clone $baseQuery)->where('status', 'picked')->count();
        $pesananPending  = (clone $baseQuery)->where('status', 'pending')->count();

        // Daftar pesanan
        $daftarPesanan = (clone $baseQuery)
            ->with(['user', 'detailPesanan.menu'])
            ->latest()
            ->get();

        // Menu terlaris
        $menuTerlaris = DetailPesanan::with('menu')
            ->whereHas('pesanan', function ($q) use ($kantin, $startDate, $endDate) {
                $q->where('kantin_id', $kantin->id)
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->selectRaw('menu_id, SUM(jumlah) as total_terjual')
            ->groupBy('menu_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // Grafik harian
        $grafikPesanan = (clone $baseQuery)
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as total_pesanan, SUM(CASE WHEN status = "picked" THEN total_harga ELSE 0 END) as pendapatan')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('penjual.laporan', compact(
            'kantin', 'periode', 'startDate', 'endDate',
            'totalPesanan', 'totalPendapatan', 'pesananSelesai', 'pesananPending',
            'daftarPesanan', 'menuTerlaris', 'grafikPesanan'
        ));
    }
}