<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $responseMessage = [
        'message' => 'REST Api'
    ];

    return response()->json($responseMessage);
});
