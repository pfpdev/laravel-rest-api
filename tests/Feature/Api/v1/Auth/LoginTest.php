<?php

namespace Tests\Feature\Api\v1\Auth;

use Tests\Feature\Api\v1\ApiV1TestCase;
use Tests\Feature\Api\v1\Helpers\CreatesTestUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends ApiV1TestCase
{
    use RefreshDatabase, CreatesTestUser;

    public function test_it_logs_in_and_returns_a_jwt_token()
    {
        $token = $this->registerAndLogin();

        $this->assertIsString($token);
        $this->assertTrue(strlen($token) > 20);
    }

    public function test_it_fails_login_with_wrong_credentials()
    {
        $creds = $this->makeTestCredentials();

        // Register
        $this->postJson('/auth/register', $creds)->assertCreated();

        // Wrong password
        $this->postJson('/auth/login', [
            'email' => $creds['email'],
            'password' => 'WrongPassword123',
        ])->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_it_fails_login_with_invalid_payload()
    {
        $this->postJson('/auth/login', [
            'email' => 'not-an-email',
            // missing password
        ])->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['email', 'password'],
            ]);
    }
}
