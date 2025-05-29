<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

/*
    fai login jwt, la response.json fai una funzione come quella mandata su wa, poi devi generare tu un refreshToken
    da 60 char (esiste func di laravel), e storarlo nel Cookie httpOnly (non nella risposta json)
*/
class AuthController extends Controller
{
    public function loginJWT(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = Auth::guard('api')->attempt($credentials)) { //guardia api e non più web
                return response()->json(['error' => 'Invalid credentials'], 401);  //try catch non serve in laravel
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
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
        return $this->respondWithTokenCookie($token, $refreshToken, $cookie);
    }


}
