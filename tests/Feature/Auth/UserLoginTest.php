<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    private User $validUserCredentials;

    private string $url = 'api/v1/auth/login';

    protected function setUp(): void
    {
        parent::setUp();
        $this->validUserCredentials = User::factory()->create();
    }

    public function testUserCanLoginWithValidCredentials(): void
    {
        $response = $this->postJson($this->url, [
            'email' => $this->validUserCredentials->email,
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => 'Login successful',
                'token' => $response->json('token'),
            ]);
    }

    public function testUserCannotLoginWithInvalidCredentials(): void
    {
        $response = $this->postJson($this->url, [
            'email' => '',
            'password' => '',
        ]);

        $response->assertUnprocessable()
            ->assertSee('is required');
    }
}
