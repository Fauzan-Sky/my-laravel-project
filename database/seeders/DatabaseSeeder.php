<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KantinSeeder::class,
            PenjualSeeder::class,
            MenuSeeder::class,
            SlotWaktuSeeder::class,
        ]);
    }
}