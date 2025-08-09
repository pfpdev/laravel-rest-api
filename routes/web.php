<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api-docs/v1', function () {
    return response()->view('api-docs.v1');
});
