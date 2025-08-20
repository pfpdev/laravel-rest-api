<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CurrentUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->name('api.v1.')
    ->group(function () {

        // ----=== PUBLIC ROUTES ===---
        Route::prefix('auth')
            ->name('auth.')
            ->group(function () {
                Route::post('/register', [AuthController::class, 'register'])->name('register');
                Route::post('/login', [AuthController::class, 'login'])->name('login');
            });

        // ----=== PROTECTED ROUTES ===---

        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::prefix('users')
                ->name('users.')
                ->group(function () {
                    Route::get('/me', [CurrentUserController::class, 'getCurrentUserDetails'])
                        ->name('me.profile');
                    Route::post('/me/profile', [CurrentUserController::class, 'updateCurrentUserDetails'])
                        ->name('me.profile.update');
                    Route::get('/me/notifications', [CurrentUserController::class, 'getCurrentUserNotificationSettings'])
                        ->name('me.notifications');
                    Route::post('/me/notifications', [CurrentUserController::class, 'updateCurrentUserNotificationSettings'])
                        ->name('me.notifications.update');
                    Route::post('/me/password', [CurrentUserController::class, 'updateCurrentUserPassword'])
                        ->name('me.password.update');
                });
        });
    });

