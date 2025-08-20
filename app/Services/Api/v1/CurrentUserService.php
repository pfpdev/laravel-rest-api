<?php

namespace App\Services\Api\v1;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CurrentUserService
{
    public function updatedCurrentUserDetails(array $inputData): ?User
    {
        try {
            $user = User::find(auth()->id());
            $user->update($inputData);

            return $user->refresh();
        } catch (\Exception $exception) { }

        return null;
    }

    public function updatedCurrentUserNotificationSettins(array $inputData): ?Notification
    {
        try {
            $userNotifications = User::find(auth()->id())->notifications;
            $userNotifications->update($inputData);

            return $userNotifications->refresh();
        } catch (\Exception $exception) { }

        return null;
    }

    public function updatedCurrentUserPassword(string $newPassword): bool
    {
        try {
            $user = User::find(auth()->id());
            $user->update(['password' => $newPassword]);

            return true;
        } catch (\Exception $exception) { }

        return false;
    }
}
