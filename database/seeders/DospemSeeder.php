<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DospemSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'dospem@sista.com'],
            [
                'name' => 'Dr. Budi Santoso',
                'role' => 'dospem',
                'password' => Hash::make('dospem12345'),
            ]
        );
    }
}
