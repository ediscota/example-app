<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Backend is working!']);
});

Route::get('/test', function() {
    return response()->json(['message' => 'Test route works']);
});

Route::prefix('v1')->group(function () {
Route::post('/login', [AuthController::class, 'loginJWT'])->name('loginJWT');
Route::post('/logout', [AuthController::class, 'logout']);

    //Route::middleware('jwt')->group(function () {
     //   Route::post('/logout', [AuthController::class, 'logout']);
   // });
});



