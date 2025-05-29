<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\Authenticate;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/web-test', function() {
    return 'Web route works!';
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware([Authenticate::class])->group(function () {
    Route::resource('/users', UsersController::class);
});
