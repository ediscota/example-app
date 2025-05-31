<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

abstract class Controller
{
    public function createCookie()
    {
        $refreshToken = Str::random(60);
        $cookie = Cookie::make(
            'refresh_token', // nome
            $refreshToken,   // valore
            60 * 24 * 7,     // durata in minuti (7 giorni)
            '/',             // path
            null,            // dominio (null = corrente)
            true,            // secure (true in produzione, richiede HTTPS)
            true             // httpOnly
        );
        return $cookie;
    }

    public function respondWithTokenCookie($token, $cookie){

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ], 200)->withCookie($cookie);
    }

}
