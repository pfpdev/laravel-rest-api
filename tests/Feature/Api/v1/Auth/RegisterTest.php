<?php

namespace Tests\Feature\Api\v1\Auth;

use Tests\Feature\Api\v1\ApiV1TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\v1\Helpers\CreatesTestUser;

class RegisterTest extends ApiV1TestCase
{
    use RefreshDatabase, CreatesTestUser;

    public function test_it_registers_a_user_successfully()
    {
        $this->postJson('/auth/register', $this->makeTestCredentials())
            ->assertCreated()
            ->assertJsonStructure([
                'message',
                'data' => [
                    'token'
                ],
            ]);
    }

    public function test_it_fails_register_when_payload_is_invalid()
    {
        $this->postJson('/auth/register', [])
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'password',
                ],
            ]);
    }

    public function test_it_fails_register_when_email_already_taken()
    {
        $payload = $this->makeTestCredentials();

        $this->postJson('/auth/register', $payload)->assertCreated();
        $this->postJson('/auth/register', $payload)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['email'],
            ]);
    }

    public function test_it_fails_register_when_phone_already_taken()
    {
        $payload = $this->makeTestCredentials();

        $this->postJson('/auth/register', $payload)->assertCreated();
        // we just change the email, to something valid but unused,
        // to make the validation pass for that field
        $payload['email'] = $payload['email'] . '.com';
        $this->postJson('/auth/register', $payload)
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => ['phone'],
            ]);
    }
}
