<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DospemSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Dosen Pembimbing 1
        User::updateOrCreate(
            ['email' => 'dospem@sista.com'],
            [
                'name' => 'Dr. Budi Santoso',
                'role' => 'dospem',
                'password' => Hash::make('dospem12345'),
            ]
        );

        // Akun Dosen Pembimbing 2
        User::updateOrCreate(
            ['email' => 'dospem2@sista.com'],
            [
                'name' => 'Dr. Andi Saputra',
                'role' => 'dospem',
                'password' => Hash::make('dospem12345'),
            ]
        );
    }
}