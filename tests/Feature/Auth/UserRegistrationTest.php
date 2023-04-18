<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    private User $validUserCredentials;

    private string $url = 'api/v1/auth/register';

    protected function setUp(): void
    {
        parent::setUp();
        $this->validUserCredentials = User::factory()->make();
    }

    public function testUserCanRegisterWithValidCredentials(): void
    {
        $this->postJson($this->url, $this->getValidUserRegistrationPayload())
            ->assertCreated()
            ->assertJson([
                'message' => 'Registration successful',
            ]);
    }

    public function testUserCannotRegisterWithInvalidCredentials(): void
    {
        $this->postJson($this->url, [$this->getInvalidUserRegistrationPayload()])
            ->assertUnprocessable()
            ->assertSee('is required');
    }

    public function testDatabaseHasUserCredentialsAfterRegistration(): void
    {
        $this->postJson($this->url, $this->getValidUserRegistrationPayload());

        $this->assertDatabaseHas('users', [
            'name' => $this->getValidUserRegistrationPayload()['name'],
            'email' => $this->getValidUserRegistrationPayload()['email'],
        ]);
    }

    public function testPreventDuplicateUserRegistrationWithSameEmail(): void
    {
        $this->postJson($this->url, $this->getValidUserRegistrationPayload());

        $this->postJson($this->url, $this->getValidUserRegistrationPayload())
            ->assertUnprocessable()
            ->assertJson([
                'message' => 'The email has already been taken.'
            ]);
    }

    private function getValidUserRegistrationPayload(): array
    {
        return [
            'name' => $this->validUserCredentials->name,
            'email' => $this->validUserCredentials->email,
            'password' => $this->validUserCredentials->password,
            'password_confirmation' => $this->validUserCredentials->password,
        ];
    }

    private function getInvalidUserRegistrationPayload(): array
    {
        return [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
    }
}
