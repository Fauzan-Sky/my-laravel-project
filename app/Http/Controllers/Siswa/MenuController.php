<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Kantin;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\SlotWaktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    // Halaman pilih menu
    public function pilihMenu($kantinId)
    {
        $kantin = Kantin::findOrFail($kantinId);

        if ($kantin->status_operasional !== 'buka') {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Kantin ' . $kantin->nama_kantinn . ' sedang tutup.');
        }

        $menuList = Menu::where('kantin_id', $kantinId)
            ->orderBy('kategori')
            ->orderBy('nama_menu')
            ->get();

        $kategoriList = $menuList->pluck('kategori')
            ->filter()
            ->unique()
            ->values();

        // Ambil slot waktu yang aktif
        // Sesuaikan nama tabel/model slot kamu
        $slotList = SlotWaktu::where('kantin_id', $kantinId)
            ->where('is_active', true)
            ->orderBy('jam_mulai')
            ->get();

        return view('siswa.pilih-menu', compact('kantin', 'menuList', 'kategoriList', 'slotList'));
    }

    // Simpan pesanan
    public function store(Request $request)
    {
        $request->validate([
            'kantin_id'   => ['required', 'exists:kantin,id'],
            'items'       => ['required', 'string'],
            'total_harga' => ['required', 'numeric', 'min:0'],
            'slot_id'     => ['required', 'exists:slot_waktu,id'], // ← tambah validasi slot
        ]);

        $user  = Auth::guard('web')->user();
        $items = json_decode($request->items, true);

        if (empty($items)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.']);
        }

        DB::beginTransaction();

        try {
            $nomorAntrean = Pesanan::where('kantin_id', $request->kantin_id)
                ->whereDate('created_at', today())
                ->count() + 1;

            $pesanan = Pesanan::create([
                'user_id'       => $user->id,
                'kantin_id'     => $request->kantin_id,
                'slot_id'       => $request->slot_id, // ← sekarang terisi
                'nomor_antrean' => $nomorAntrean,
                'status'        => 'pending',
                'total_harga'   => $request->total_harga,
                'catatan'       => $request->catatan,
                'tanggal_pesan' => today(),
            ]);

            foreach ($items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);

                if ($menu->stok < $item['jumlah']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok "' . $menu->nama_menu . '" tidak mencukupi.'
                    ]);
                }

                DetailPesanan::create([
                    'pesanan_id'   => $pesanan->id,
                    'menu_id'      => $item['menu_id'],
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal'     => $item['harga_satuan'] * $item['jumlah'],
                ]);

                $menu->decrement('stok', $item['jumlah']);
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
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}