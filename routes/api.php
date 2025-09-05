<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\CityController;
use App\Http\Controllers\Api\v1\CountyController;
use App\Http\Controllers\Api\v1\CurrentUserController;
use App\Http\Controllers\Api\v1\LocationController;
use App\Http\Controllers\Api\v1\OpeningHoursController;
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

        Route::prefix('categories')
            ->name('categories.')
            ->group(function () {
                Route::get('/', [CategoryController::class, 'index'])->name('index');
            });
        Route::prefix('counties')
            ->name('counties.')
            ->group(function () {
                Route::get('/', [CountyController::class, 'index'])->name('index');
            });
        Route::prefix('cities')
            ->name('cities.')
            ->group(function () {
                Route::get('/', [CityController::class, 'index'])->name('index');
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

            Route::prefix('locations')
                ->name('locations.')
                ->group(function () {
                    /* Locations CRUD Operations   */
                    Route::get('/', [LocationController::class, 'index'])->name('index');
                    Route::get('/{user}', [LocationController::class, 'index'])->name('index');
                    Route::post('/', [LocationController::class, 'store'])->name('store');
                    Route::get('/{location}', [LocationController::class, 'show'])
                        ->name('show');
                    Route::patch('/{location}', [LocationController::class, 'update'])
                        ->name('patch');
                    Route::delete('/{location}', [LocationController::class, 'destroy'])
                        ->name('destroy');
                    /* Locations State Transitions Operations */
                    Route::patch('/{location}/activate', [LocationController::class, 'activate'])
                        ->name('activate');
                    Route::patch('/{location}/deactivate', [LocationController::class, 'deactivate'])
                        ->name('deactivate');
                    Route::patch('/{location}/archive', [LocationController::class, 'archive'])
                        ->name('archive');
                    /* Locations Opening Hours update */
                    Route::patch('/{location}/opening-hours', [OpeningHoursController::class, 'update'])
                        ->name('locations.opening-hours.update');
                });
        });
    });

