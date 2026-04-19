<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenjualSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kantin berdasarkan nama
        $kantinA = DB::table('kantin')->where('nama_kantinn', 'Kantin A')->first();
        $kantinB = DB::table('kantin')->where('nama_kantinn', 'Kantin B')->first();
        $kantinC = DB::table('kantin')->where('nama_kantinn', 'Kantin C')->first();

        DB::table('penjual')->insert([
            [
                'kantin_id' => $kantinA->id,
                'nama'      => 'Penjual Kantin A',
                'email'     => 'kantina@kantinku.com',
                'password'  => Hash::make('password'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kantin_id' => $kantinB->id,
                'nama'      => 'Penjual Kantin B',
                'email'     => 'kantinb@kantinku.com',
                'password'  => Hash::make('password'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kantin_id' => $kantinC->id,
                'nama'      => 'Penjual Kantin C',
                'email'     => 'kantinc@kantinku.com',
                'password'  => Hash::make('password'),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}