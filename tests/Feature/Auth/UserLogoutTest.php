<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLogoutTest extends TestCase
{
    private User $validUserCredentials;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validUserCredentials = User::factory()->create();
    }

    public function testUserCanLogout(): void
    {
        $response = $this->postJson('api/v1/auth/login', [
            'email' => $this->validUserCredentials->email,
            'password' => 'password',
        ])->assertOk()
            ->assertJson([
                'message' => 'Login successful',
            ]);

        $this->withToken($response->json('token'))
            ->post('api/v1/logout')
            ->assertOk()
            ->assertJson([
                'message' => 'Logout successful',
            ]);
    }
}
