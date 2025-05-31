<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
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
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
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
        DB::table('users')->where('id', Auth::guard('api')->id())->update(['refresh_token' => $refreshToken]);
        return $this->respondWithTokenCookie($token, $cookie);
    }
    public function logout(Request $request)
    {
        //puoi prendere il refreshToken dal cookie, fai query selezionando l'user per il refreshToken e puoi pulire in questo modo il refreshToken dal Db,
        //,invece che accedere grazie all'user autenticato, che se non è autenticato devi per forza sovrascrivere il refreshToken dato che non puoi accedere al DB per pulirllo
        $refreshToken = $request->cookie('refresh_token');
        if ($refreshToken) {
            $user = DB::table('users')->where('refresh_token', $refreshToken)->first();
            if ($user) {
                DB::table('users')->where('id', $user->id)->update(['refresh_token' => '']);
            }
        }
        Auth::guard('api')->logout();
        $cookie = Cookie::forget('refresh_token');
        return response()->json(['message' => 'Logout effettuato con successo.'])->withCookie($cookie);
    }
    public function getRefreshToken(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token non presente'], 404);
        }
        return response()->json(['refresh_token' => $refreshToken]);
    }
    public function refreshToken(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token mancante'], 401);
        }
        $user = DB::table('users')->where('refresh_token', $refreshToken)->first();
        if (!$user) {
            return response()->json(['error' => 'Refresh token non valido'], 401);
        }
        $cookie = Cookie::make(
            'refresh_token',
            $refreshToken,
            60 * 24 * 7,
            '/',
            null,
            true,
            true
        );
        //login() si differenzia da attempt usato in loginJWT perchè non vuole come param email e pw, usa direttamente l'utente già autenticato
        $token = Auth::guard('api')->login(User::find($user->id));
        return $this->respondWithTokenCookie($token, $cookie);
    }
}
