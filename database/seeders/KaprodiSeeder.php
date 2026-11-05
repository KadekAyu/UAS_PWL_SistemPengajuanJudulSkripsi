<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class KaprodiSeeder extends Seeder
{
    public function run(): void
    {
        $name = config('sista.kaprodi.name');
        $email = config('sista.kaprodi.email');
        $password = config('sista.kaprodi.password');

        if (blank($name) || blank($email) || blank($password)) {
            throw new RuntimeException('Set KAPRODI_NAME, KAPRODI_EMAIL, and KAPRODI_PASSWORD in .env before seeding.');
        }

        $kaprodi = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
                'role' => 'kaprodi',
            ],
        );

        if ($kaprodi->role !== 'kaprodi') {
            throw new RuntimeException("The email {$email} is already assigned to a non-Kaprodi account.");
        }
    }
}
