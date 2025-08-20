<?php

namespace Tests\Feature\Api\v1\Users;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\Feature\Api\v1\ApiV1TestCase;
use Tests\Feature\Api\v1\Helpers\CreatesTestUser;

class PasswordUpdateTest extends ApiV1TestCase
{
    use RefreshDatabase, CreatesTestUser;

    public function test_it_updates_password_with_valid_payload_and_returns_201()
    {
        $userDetails = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'John@Doe.com',
            'phone' => '+40762248238',
            'password' => 'OldPass123',
        ];

        $user = $this->postJson('/api/v1/auth/register', $userDetails)->assertCreated();

        $this->postJson('/users/me/password', [
            'password'     => 'OldPass123',
            'new_password' => 'NewPass456',
        ], [
            'Authorization' => 'Bearer '.$user['data']['token'],
            'Accept'        => 'application/json',
        ])->assertStatus(201)
            ->assertExactJson([]); // controller returns json([], 201)
    }

    public function test_it_requires_authentication()
    {
        $this->postJson('/users/me/password', [
            'password'     => 'anything',
            'new_password' => 'anythingElse',
        ])->assertStatus(401)
            ->assertJsonStructure(['message']);
    }

    public function test_it_rejects_invalid_bearer_token()
    {
        $this->postJson('/users/me/password', [
            'password'     => 'anything',
            'new_password' => 'anythingElse',
        ], [
            'Authorization' => 'Bearer invalid.token.here',
            'Accept'        => 'application/json',
        ])->assertStatus(401)
            ->assertJsonStructure(['message']);
    }

    public function test_it_fails_when_current_password_is_incorrect()
    {
        $token = $this->registerAndLogin();
        $user  = User::firstOrFail();

        $user->forceFill(['password' => Hash::make('CorrectPass1')])->save();

        $this->postJson('/users/me/password', [
            'password'     => 'WrongPass1',
            'new_password' => 'NewPass456',
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['password']]);
    }

    public function test_it_fails_when_new_password_is_same_as_current()
    {
        $token = $this->registerAndLogin();
        $user  = User::firstOrFail();

        $user->forceFill(['password' => Hash::make('SamePass9')])->save();

        $this->postJson('/users/me/password', [
            'password'     => 'SamePass9',
            'new_password' => 'SamePass9', // triggers different:password
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['new_password']]);
    }

    public function test_it_fails_when_current_password_is_too_short()
    {
        $token = $this->registerAndLogin();
        $user  = User::firstOrFail();

        $user->forceFill(['password' => Hash::make('CorrectLen')])->save();

        $this->postJson('/users/me/password', [
            'password'     => 'short', // < 6
            'new_password' => 'LongEnough1',
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['password']]);
    }

    public function test_it_fails_when_new_password_is_too_short()
    {
        $token = $this->registerAndLogin();
        $user  = User::firstOrFail();

        $user->forceFill(['password' => Hash::make('CorrectLen')])->save();

        $this->postJson('/users/me/password', [
            'password'     => 'CorrectLen',
            'new_password' => 'short', // < 6
        ], [
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['new_password']]);
    }
}
