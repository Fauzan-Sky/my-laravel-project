<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'kantin', 'detail.menu'])->latest();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->tanggal) {
            $query->whereDate('tanggal_pesan', $request->tanggal);
        }

        $orders = $query->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(string $id)
    {
        $order = Pesanan::with(['user', 'kantin', 'slot', 'detail.menu'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,picked,cancelled',
        ]);

        $order = Pesanan::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Status pesanan berhasil diupdate.');
    }

    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,picked,cancelled',
        ]);

        $order = Pesanan::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diupdate.');
    }
}