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

            // Nomor antrean reset tiap hari per kantin
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

                // Kurangi stok
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
}