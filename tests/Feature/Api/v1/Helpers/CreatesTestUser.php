<?php

namespace Tests\Feature\Api\v1\Helpers;

use Illuminate\Support\Str;

trait CreatesTestUser
{
    protected function makeTestCredentials(): array
    {
        $password = 'Password!234';
        $email = 'user_'.Str::random(8).'@example.test';

        return [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $email,
            'phone' => '+40762248238',
            'password' => $password,
        ];
    }

    protected function registerAndLogin(): string
    {
        // Register
        $creds = $this->makeTestCredentials();
        $this->postJson('/api/v1/auth/register', $creds)
            ->assertCreated()
            ->assertJsonStructure([
                'message',
                'data' => ['token'],
            ]);

        // Login (your OpenAPI shows token under data.token)
        $login = $this->postJson('/api/v1/auth/login', [
            'email' => $creds['email'],
            'password' => $creds['password'],
        ])->assertOk()
            ->assertJsonStructure([
                'message',
                'data' => ['token'],
            ])
            ->json('data');

        return $login['token'];
    }
}
