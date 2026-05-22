<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function store(Request $request)
    {
        // Decode items dari JSON string jadi array
        $itemsRaw = $request->input('items');
        if (is_string($itemsRaw)) {
            $items = json_decode($itemsRaw, true);
            $request->merge(['items' => $items]);
        }

        $request->validate([
            'kantin_id'            => ['required', 'exists:kantin,id'],
            'items'                => ['required', 'array', 'min:1'],
            'items.*.menu_id'      => ['required'],
            'items.*.jumlah'       => ['required', 'integer', 'min:1'],
            'items.*.harga_satuan' => ['required', 'numeric'],
            'items.*.subtotal'     => ['required', 'numeric'],
            'total_harga'          => ['required', 'numeric'],
        ]);

        $user = Auth::guard('web')->user();

        try {
            DB::beginTransaction();

            $nomorAntrean = Pesanan::where('kantin_id', $request->kantin_id)
                ->whereDate('created_at', today())
                ->count() + 1;

            $pesanan = Pesanan::create([
                'user_id'       => $user->id,
                'kantin_id'     => $request->kantin_id,
                'nomor_antrean' => $nomorAntrean,
                'status'        => 'pending',
                'total_harga'   => $request->total_harga,
                'catatan'       => $request->catatan ?? null,
                'tanggal_pesan' => today(),
            ]);

            foreach ($request->items as $item) {
                DetailPesanan::create([
                    'pesanan_id'   => $pesanan->id,
                    'menu_id'      => $item['menu_id'],
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal'     => $item['subtotal'],
                ]);

                Menu::where('id', $item['menu_id'])->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            return response()->json([
                'success'       => true,
                'nomor_antrean' => $nomorAntrean,
                'pesanan_id'    => $pesanan->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ✅ Polling JS — cek apakah ada pesanan siswa yang statusnya ready
    public function cekReady()
    {
        $user = Auth::guard('web')->user();

        $pesanan = Pesanan::with('kantin')
            ->where('user_id', $user->id)
            ->where('status', 'ready')
            ->whereDate('created_at', today())
            ->first();

        if (!$pesanan) {
            return response()->json(['ada' => false]);
        }

        return response()->json([
            'ada'            => true,
            'pesanan_id'     => $pesanan->id,
            'nomor_antrean'  => str_pad($pesanan->nomor_antrean, 3, '0', STR_PAD_LEFT),
            'nama_kantin'    => $pesanan->kantin->nama_kantin ?? '-',
            'deadline_ambil' => $pesanan->deadline_ambil?->format('H:i'),
        ]);
    }

    // ✅ Siswa konfirmasi sudah ambil pesanan
    public function konfirmasiAmbil($id)
    {
        $user = Auth::guard('web')->user();

        $pesanan = Pesanan::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 'ready')
            ->firstOrFail();

        $pesanan->update([
            'status'        => 'picked',
            'waktu_diambil' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}