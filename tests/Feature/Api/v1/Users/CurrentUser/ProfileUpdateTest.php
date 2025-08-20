<?php

namespace Tests\Feature\Api\v1\Users\CurrentUser;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\v1\ApiV1TestCase;
use Tests\Feature\Api\v1\Helpers\CreatesTestUser;

class ProfileUpdateTest extends ApiV1TestCase
{
    use RefreshDatabase, CreatesTestUser;

    public function test_it_updates_profile_with_valid_payload()
    {
        $token = $this->registerAndLogin();

        $payload = [
            'first_name' => 'Jane',
            'last_name'  => 'Doe',
            'email'      => 'jane.doe@example.com',
            'phone'      => '+40700111222',
        ];

        $this->postJson('/users/me/profile', $payload, [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->assertStatus(200);
    }

    public function test_it_rejects_when_unauthenticated()
    {
        $this->postJson('/users/me/profile', [
            'first_name' => 'Jane',
        ])->assertStatus(401)
            ->assertJsonStructure(['message']);
    }

    public function test_it_rejects_invalid_email_format()
    {
        $token = $this->registerAndLogin();

        $this->postJson('/users/me/profile', [
            'email' => 'not-an-email',
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    public function test_it_rejects_invalid_phone_format()
    {
        $token = $this->registerAndLogin();

        $this->postJson('/users/me/profile', [
            'phone' => '0040-700-111-222', // fails the E.164-like regex
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['phone']]);
    }

    public function test_it_rejects_duplicate_email_of_another_user()
    {
        $token = $this->registerAndLogin();

        // Another user claims the target email
        User::factory()->create(['email' => 'taken@example.com']);

        $this->postJson('/users/me/profile', [
            'email' => 'taken@example.com',
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['email']]);
    }

    public function test_it_rejects_duplicate_phone_of_another_user()
    {
        $token = $this->registerAndLogin();

        // Another user already has this phone
        User::factory()->create(['phone' => '+40700111222']);

        $this->postJson('/users/me/profile', [
            'phone' => '+40700111222',
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['phone']]);
    }

    public function test_it_allows_keeping_the_same_email()
    {
        // Register and login, then fetch the current user
        $token = $this->registerAndLogin();
        $currentUser = User::query()->firstOrFail();

        // Attempt to set email to the same value (should pass due to ignore rule)
        $this->postJson('/users/me/profile', [
            'email' => $currentUser->email,
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->assertStatus(200);
    }

    public function test_it_allows_partial_updates_without_other_fields()
    {
        $token = $this->registerAndLogin();

        $this->postJson('/users/me/profile', [
            'first_name' => 'OnlyFirstName',
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])->assertStatus(200);
    }
}
