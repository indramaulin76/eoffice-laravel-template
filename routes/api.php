<?php

use App\Http\Controllers\Api\BawahanController;
use App\Http\Controllers\Api\LogController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));

Route::get('/log/{id}', [LogController::class, 'getById']);

Route::get('/bawahan/{id}', [BawahanController::class, 'getById']);
