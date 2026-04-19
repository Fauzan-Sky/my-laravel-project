<?php
// database/seeders/SlotWaktuSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotWaktuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('slot_waktu')->insert([
            [
                'label_slot'  => 'Istirahat 1',
                'jam_mulai'   => '09:10:00',
                'jam_selesai' => '09:30:00',
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'label_slot'  => 'Istirahat 2',
                'jam_mulai'   => '11:30:00',
                'jam_selesai' => '13:00:00',
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}