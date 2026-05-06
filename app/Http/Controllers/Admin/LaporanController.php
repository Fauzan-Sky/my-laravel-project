<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'hari');

        switch ($periode) {
            case 'minggu':
                $start = Carbon::now()->startOfWeek();
                $end   = Carbon::now()->endOfWeek();
                break;
            case 'bulan':
                $start = Carbon::now()->startOfMonth();
                $end   = Carbon::now()->endOfMonth();
                break;
            case 'custom':
                $start = $request->tanggal_mulai
                    ? Carbon::parse($request->tanggal_mulai)->startOfDay()
                    : Carbon::now()->startOfDay();
                $end = $request->tanggal_selesai
                    ? Carbon::parse($request->tanggal_selesai)->endOfDay()
                    : Carbon::now()->endOfDay();
                break;
            default:
                $start = Carbon::now()->startOfDay();
                $end   = Carbon::now()->endOfDay();
                break;
        }

        $orders = Order::with(['items.menu', 'user'])
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        $totalPesanan    = $orders->count();
        $totalPendapatan = $orders->where('status', 'selesai')->sum('total_harga');
        $pesananSelesai  = $orders->where('status', 'selesai')->count();
        $pesananPending  = $orders->whereIn('status', ['pending', 'diproses', 'siap'])->count();

        $menuTerlaris = OrderItem::with('menu')
            ->whereHas('order', fn($q) => $q->whereBetween('created_at', [$start, $end]))
            ->selectRaw('menu_id, SUM(jumlah) as total_terjual, SUM(subtotal) as total_pendapatan')
            ->groupBy('menu_id')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        return view('admin.laporan.index', compact(
            'orders',
            'totalPesanan',
            'totalPendapatan',
            'pesananSelesai',
            'pesananPending',
            'menuTerlaris',
            'periode',
            'start',
            'end'
        ));
    }
}