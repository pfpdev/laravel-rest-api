<?php

namespace Tests\Feature\Api\v1\Users\CurrentUser;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\v1\ApiV1TestCase;
use Tests\Feature\Api\v1\Helpers\CreatesTestUser;

class NotificationSettingsUpdateTest extends ApiV1TestCase
{
    use RefreshDatabase, CreatesTestUser;

    public function test_it_updates_notification_settings_with_valid_boolean_values()
    {
        $token = $this->registerAndLogin();
        /** @var \App\Models\User $user */
        $user = User::firstOrFail();

        $payload = [
            'reminder_email'  => 1,
            'reminder_sms'    => 0,
            'booking_updates' => 1,
            'marketing_email' => 0,
        ];

        $this->postJson('/users/me/notifications', $payload, [
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'application/json',
        ])->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'reminder_email',
                    'reminder_sms',
                    'booking_updates',
                    'marketing_email',
                ],
            ])
            // Assuming NotificationsResource returns raw tinyints (0/1) without casts
            ->assertJsonPath('data.reminder_email', true)
            ->assertJsonPath('data.reminder_sms', false)
            ->assertJsonPath('data.booking_updates', true)
            ->assertJsonPath('data.marketing_email', false);
    }

    public function test_it_allows_partial_update()
    {
        $token = $this->registerAndLogin();

        // Only change one field
        $payload = ['reminder_sms' => true];

        $this->postJson('/users/me/notifications', $payload, [
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'application/json',
        ])->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'reminder_email',
                    'reminder_sms',
                    'booking_updates',
                    'marketing_email',
                ],
            ])
            ->assertJsonPath('data.reminder_sms', true);
    }

    public function test_it_rejects_invalid_values()
    {
        $token = $this->registerAndLogin();

        $payload = [
            'reminder_email'  => 'maybe',
            'reminder_sms'    => 'sometimes',
            'booking_updates' => 1234,
            'marketing_email' => 'yesplease',
        ];

        $this->postJson('/users/me/notifications', $payload, [
            'Authorization' => 'Bearer '.$token,
            'Accept'        => 'application/json',
        ])->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'reminder_email',
                    'reminder_sms',
                    'booking_updates',
                    'marketing_email',
                ],
            ]);
    }

    public function test_it_requires_authentication()
    {
        $this->postJson('/users/me/notifications', [
            'reminder_email' => true,
        ])->assertStatus(401)
            ->assertJsonStructure(['message']);
    }

    public function test_it_rejects_invalid_bearer_token()
    {
        $this->postJson('/users/me/notifications', [
            'reminder_sms' => false,
        ], [
            'Authorization' => 'Bearer invalid.token.here',
            'Accept'        => 'application/json',
        ])->assertStatus(401)
            ->assertJsonStructure(['message']);
    }
}
