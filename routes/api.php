<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['message' => 'Backend is working!']);
});

Route::prefix('api/v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('loginJWT');
    Route::middleware('jwt')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    //capire perchè su Postman da errore 404 non trovando quella url, c'è qualcosa che non va nelle routes, nelle versioni precedenti in automatico faceva api/v1
});
