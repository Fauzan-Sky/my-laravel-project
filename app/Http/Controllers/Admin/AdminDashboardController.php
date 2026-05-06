<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\User;
use App\Models\Kantin;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_menu'       => Menu::count(),
            'total_order'      => Pesanan::count(),
            'total_user'       => User::count(),
            'total_revenue'    => Pesanan::where('status', 'picked')->sum('total_harga'),
            'order_hari_ini'   => Pesanan::whereDate('created_at', today())->count(),
            'revenue_hari_ini' => Pesanan::where('status', 'picked')
                                    ->whereDate('created_at', today())
                                    ->sum('total_harga'),
            'order_pending'    => Pesanan::where('status', 'pending')->count(),
        ];

        $recent_orders = Pesanan::with('user')->latest()->take(5)->get();

        $revenue_chart = Pesanan::where('status', 'picked')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recent_orders', 'revenue_chart'));
    }

    public function laporan(Request $request)
    {
        // Filter periode
        $periode = $request->get('periode', 'hari');
        $startDate = match($periode) {
            'minggu' => Carbon::now()->startOfWeek(),
            'bulan'  => Carbon::now()->startOfMonth(),
            default  => Carbon::today(),
        };
        $endDate = Carbon::now();

        // Jika custom tanggal
        if ($request->filled('dari') && $request->filled('sampai')) {
            $startDate = Carbon::parse($request->dari)->startOfDay();
            $endDate   = Carbon::parse($request->sampai)->endOfDay();
            $periode   = 'custom';
        }

        $baseQuery = Pesanan::whereBetween('created_at', [$startDate, $endDate]);

        // Ringkasan
        $totalPesanan    = (clone $baseQuery)->count();
        $totalPendapatan = (clone $baseQuery)->where('status', 'picked')->sum('total_harga');
        $pesananSelesai  = (clone $baseQuery)->where('status', 'picked')->count();
        $pesananPending  = (clone $baseQuery)->where('status', 'pending')->count();

        // Pesanan per kantin
        $pesananPerKantin = Kantin::withCount(['pesanan' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate]);
        }])->withSum(['pesanan' => function ($q) use ($startDate, $endDate) {
            $q->whereBetween('created_at', [$startDate, $endDate])->where('status', 'picked');
        }], 'total_harga')->get();

        // Menu terlaris
        $menuTerlaris = \App\Models\DetailPesanan::with('menu')
            ->whereHas('pesanan', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->selectRaw('menu_id, SUM(jumlah) as total_terjual')
            ->groupBy('menu_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // Grafik pesanan harian
        $grafikPesanan = (clone $baseQuery)
            ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as total_pesanan, SUM(CASE WHEN status = "picked" THEN total_harga ELSE 0 END) as pendapatan')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.laporan.index', compact(
            'periode', 'startDate', 'endDate',
            'totalPesanan', 'totalPendapatan', 'pesananSelesai', 'pesananPending',
            'pesananPerKantin', 'menuTerlaris', 'grafikPesanan'
        ));
    }
}