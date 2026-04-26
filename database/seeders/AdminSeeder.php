<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@kantinku2.com'],
            [
                'name'      => 'Admin Kantin',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'is_active' => true,
            ]
        );

        $this->command->info('✅ Login: admin@kantinku2.com / admin123');
    }
}