<?php

namespace Tests\Feature\Api\v1\Users;

use Tests\Feature\Api\v1\ApiV1TestCase;
use Tests\Feature\Api\v1\Helpers\CreatesTestUser;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MeTest extends ApiV1TestCase
{
    use RefreshDatabase, CreatesTestUser;

    public function test_it_returns_the_current_user_profile_when_authenticated()
    {
        $token = $this->registerAndLogin();

        $this->getJson('/users/me', [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                ],
            ]);
    }

    public function test_it_fails_when_missing_bearer_token()
    {
        $this->getJson('/users/me')
            ->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }

    public function test_it_fails_with_invalid_bearer_token()
    {
        $this->getJson('/users/me', [
            'Authorization' => 'Bearer invalid.token.here',
            'Accept' => 'application/json',
        ])->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
