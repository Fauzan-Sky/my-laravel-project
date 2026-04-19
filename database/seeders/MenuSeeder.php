<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $kantinA  = DB::table('kantin')->where('nama_kantinn', 'Kantin A')->first();
        $kantinB  = DB::table('kantin')->where('nama_kantinn', 'Kantin B')->first();
        $kantinC  = DB::table('kantin')->where('nama_kantinn', 'Kantin C')->first();

        $penjualA = DB::table('penjual')->where('email', 'kantina@kantinku.com')->first();
        $penjualB = DB::table('penjual')->where('email', 'kantinb@kantinku.com')->first();
        $penjualC = DB::table('penjual')->where('email', 'kantinc@kantinku.com')->first();

        $menus = [
            // ── Kantin A ──
            ['kantin_id' => $kantinA->id, 'penjual_id' => $penjualA->id, 'nama_menu' => 'Nasi Goreng',      'kategori' => 'makanan',  'harga' => 10000, 'stok' => 20],
            ['kantin_id' => $kantinA->id, 'penjual_id' => $penjualA->id, 'nama_menu' => 'Mie Ayam',         'kategori' => 'makanan',  'harga' => 9000,  'stok' => 15],
            ['kantin_id' => $kantinA->id, 'penjual_id' => $penjualA->id, 'nama_menu' => 'Es Teh Manis',     'kategori' => 'minuman',  'harga' => 3000,  'stok' => 30],
            ['kantin_id' => $kantinA->id, 'penjual_id' => $penjualA->id, 'nama_menu' => 'Jus Jeruk',        'kategori' => 'minuman',  'harga' => 5000,  'stok' => 20],

            // ── Kantin B ──
            ['kantin_id' => $kantinB->id, 'penjual_id' => $penjualB->id, 'nama_menu' => 'Ayam Geprek',      'kategori' => 'makanan',  'harga' => 12000, 'stok' => 25],
            ['kantin_id' => $kantinB->id, 'penjual_id' => $penjualB->id, 'nama_menu' => 'Bakso',            'kategori' => 'makanan',  'harga' => 10000, 'stok' => 20],
            ['kantin_id' => $kantinB->id, 'penjual_id' => $penjualB->id, 'nama_menu' => 'Es Jeruk',         'kategori' => 'minuman',  'harga' => 4000,  'stok' => 25],
            ['kantin_id' => $kantinB->id, 'penjual_id' => $penjualB->id, 'nama_menu' => 'Air Mineral',      'kategori' => 'minuman',  'harga' => 3000,  'stok' => 50],

            // ── Kantin C ──
            ['kantin_id' => $kantinC->id, 'penjual_id' => $penjualC->id, 'nama_menu' => 'Soto Ayam',        'kategori' => 'makanan',  'harga' => 11000, 'stok' => 20],
            ['kantin_id' => $kantinC->id, 'penjual_id' => $penjualC->id, 'nama_menu' => 'Gado-Gado',        'kategori' => 'makanan',  'harga' => 9000,  'stok' => 15],
            ['kantin_id' => $kantinC->id, 'penjual_id' => $penjualC->id, 'nama_menu' => 'Es Cincau',        'kategori' => 'minuman',  'harga' => 4000,  'stok' => 20],
            ['kantin_id' => $kantinC->id, 'penjual_id' => $penjualC->id, 'nama_menu' => 'Teh Botol',        'kategori' => 'minuman',  'harga' => 4000,  'stok' => 30],
        ];

        foreach ($menus as $menu) {
            DB::table('menu')->insert(array_merge($menu, [
                'deskripsi'    => null,
                'foto'         => null,
                'is_available' => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]));
        }
    }
}