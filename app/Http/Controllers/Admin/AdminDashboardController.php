<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_menu'       => Menu::count(),
            'total_order'      => Order::count(),
            'total_user'       => User::count(),
            'total_revenue'    => Order::where('status', 'selesai')->sum('total_harga'),
            'order_hari_ini'   => Order::whereDate('created_at', today())->count(),
            'revenue_hari_ini' => Order::where('status', 'selesai')
                                    ->whereDate('created_at', today())
                                    ->sum('total_harga'),
            'order_pending'    => Order::where('status', 'pending')->count(),
        ];

        $recent_orders = Order::with('user')->latest()->take(5)->get();

        $revenue_chart = Order::where('status', 'selesai')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recent_orders', 'revenue_chart'));
    }
}