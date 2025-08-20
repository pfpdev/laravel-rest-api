<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Users\CurrentUser\NotificationsUpdateRequest;
use App\Http\Requests\Api\v1\Users\CurrentUser\PasswordUpdateRequest;
use App\Http\Requests\Api\v1\Users\CurrentUser\ProfileUpdateRequest;
use App\Http\Resources\Api\v1\Users\CurrentUser\NotificationsResource;
use App\Http\Resources\Api\v1\Users\CurrentUser\ProfileResource;
use App\Services\Api\v1\CurrentUserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;


class CurrentUserController extends Controller
{
    public function __construct(
        private readonly CurrentUserService $service
    ) {}

    public function getCurrentUserDetails(Request $request): ProfileResource
    {
        return new ProfileResource(auth()->user());
    }

    public function updateCurrentUserDetails(ProfileUpdateRequest $request): ProfileResource
    {
        $updatedUser = $this->service->updatedCurrentUserDetails($request->validated());

        if ($updatedUser === null) {
            abort(500);
        }

        return new ProfileResource($updatedUser);
    }

    public function getCurrentUserNotificationSettings(Request $request): NotificationsResource
    {
        return new NotificationsResource(auth()->user()->notifications);
    }

    public function updateCurrentUserNotificationSettings(NotificationsUpdateRequest $request): NotificationsResource
    {
        $updatedNotifications = $this->service->updatedCurrentUserNotificationSettins($request->validated());

        if ($updatedNotifications === null) {
            abort(500);
        }

        return new NotificationsResource($updatedNotifications);
    }

    public function updateCurrentUserPassword(PasswordUpdateRequest $request): JsonResponse
    {
        $updatePassword = $this->service->updatedCurrentUserPassword($request->validated()['password']);
        if ($updatePassword === false) {
            abort(500);
        }

        return response()->json([], 201);
    }
}
