<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_homepage_redirects_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_non_kaprodi_users_cannot_open_the_kaprodi_dashboard(): void
    {
        $user = new User([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@example.test',
            'password' => 'secret',
            'role' => 'mahasiswa',
        ]);

        $this->actingAs($user)
            ->get('/kaprodi/dashboard')
            ->assertForbidden();
    }
}
