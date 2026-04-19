<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KantinSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kantin')->insert([
            [
                'nama_kantinn'       => 'Kantin A',
                'deskripsi'          => 'Kantin utama sekolah',
                'lokasi'             => 'Sekolah SMKN 11 Bandung',
                'status_operasional' => 'buka',
                'jam_buka'           => '07:00:00',
                'jam_tutup'          => '15:00:00',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'nama_kantinn'       => 'Kantin B',
                'deskripsi'          => 'Kantin utama sekolah',
                'lokasi'             => 'Sekolah SMKN 11 Bandung',
                'status_operasional' => 'buka',
                'jam_buka'           => '07:00:00',
                'jam_tutup'          => '15:00:00',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'nama_kantinn'       => 'Kantin C',
                'deskripsi'          => 'Kantin utama sekolah',
                'lokasi'             => 'Sekolah SMKN 11 Bandung',
                'status_operasional' => 'buka',
                'jam_buka'           => '07:00:00',
                'jam_tutup'          => '15:00:00',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}