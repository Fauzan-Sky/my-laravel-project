<?php
namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:pending,processing,ready,picked'],
        ]);

        $penjual = Auth::guard('penjual')->user();
        $pesanan = Pesanan::where('id', $id)
            ->where('kantin_id', $penjual->kantin_id)
            ->firstOrFail();

        $pesanan->update([
            'status'        => $request->status,
            'waktu_diambil' => $request->status === 'picked' ? now() : $pesanan->waktu_diambil,
            'deadline_ambil' => $request->status === 'ready' ? now()->addMinutes(15) : $pesanan->deadline_ambil, // ✅ Tambah ini
        ]);

        return back()->with('success', 'Status pesanan #' . str_pad($pesanan->nomor_antrean, 3, '0', STR_PAD_LEFT) . ' berhasil diperbarui.');
    }

    // ✅ Method baru — penjual konfirmasi pesanan sudah diambil
    public function tandaiDiambil($id)
    {
        $penjual = Auth::guard('penjual')->user();
        $pesanan = Pesanan::where('id', $id)
            ->where('kantin_id', $penjual->kantin_id)
            ->where('status', 'ready')
            ->firstOrFail();

        $pesanan->update([
            'status'        => 'picked',
            'waktu_diambil' => now(),
        ]);

        return back()->with('success', 'Pesanan #' . str_pad($pesanan->nomor_antrean, 3, '0', STR_PAD_LEFT) . ' ditandai sudah diambil.');
    }
}