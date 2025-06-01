<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersControllerAPI;

Route::get('/', function () {
    return response()->json(['message' => 'Backend is working!']);
});

Route::get('/test', function() {
    return response()->json(['message' => 'Test route works']);
});

Route::prefix('v1')->group(function () {
Route::post('/login', [AuthController::class, 'loginJWT']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/get-refresh-token', [AuthController::class, 'getRefreshToken']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
Route::get('/users', [UsersControllerAPI::class, 'getIndex'])->middleware('auth:api');

    //Route::middleware('jwt')->group(function () {
     //   Route::post('/logout', [AuthController::class, 'logout']);
   // });
});



