<?php

namespace Database\Seeders;

use App\Models\Kantin;
use Illuminate\Database\Seeder;

class KantinSeeder2 extends Seeder
{
    public function run(): void
    {
        Kantin::insert([
            [
                'nama_kantinn'        => 'Kantin B',
                'lokasi'              => 'Sekolah SMKN 11 Bandung',
                'deskripsi'           => 'Kantin C SMKN 11 Bandung',
                'status_operasional'  => 'buka',
                'jam_buka'            => '07:00:00',
                'jam_tutup'           => '15:00:00',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'nama_kantinn'        => 'Kantin C',
                'lokasi'              => 'Sekolah SMKN 11 Bandung',
                'deskripsi'           => 'Kantin C SMKN 11 Bandung',
                'status_operasional'  => 'buka',
                'jam_buka'            => '07:00:00',
                'jam_tutup'           => '15:00:00',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
        ]);
    }
}