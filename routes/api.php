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
    Route::middleware('jwt')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    //capire perchè su Postman da errore 404 non trovando quella url, c'è qualcosa che non va nelle routes, nelle versioni precedenti in automatico faceva api/v1
});

/*
    Attualmente get http://localhost/example-app/public/api/test da 200, se levo le righe commentate no, o perlomeno
    prima no, dato che prefix era api/v1, ma api era gia impostato su bootstrap/app.php quindi si doppiava.
*/
