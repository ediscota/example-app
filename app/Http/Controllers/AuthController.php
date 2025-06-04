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
        $refreshToken = $request->cookie('refresh_token');
        //inizializza il cookie con make
        $cookie = Cookie::make(
            'refresh_token',
            $refreshToken,
            60 * 24 * 7,
            '/',
            null,
            true,
            true
        );
        if ($refreshToken) {
            $user = DB::table('users')->where('refresh_token', $refreshToken)->first();
            if ($user) {
                DB::table('users')->where('id', $user->id)->update(['refresh_token' => null]);//null
                Auth::guard('api')->logout();
            }
            $cookie = Cookie::forget('refresh_token');
        }
        return response()->json(['message' => 'Logout effettuato con successo.'])->withCookie($cookie);//se non lo inizializzi qui problemi
    }
    public function getRefreshToken(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token non presente'], 401); //unauthorized
        }
        return response()->json(['refresh_token' => $refreshToken]);
    }
    public function refreshToken(Request $request)
    {
        $refreshToken = $request->cookie('refresh_token');
        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token non presente'], 401);
        }
        $user = DB::table('users')->where('refresh_token', $refreshToken)->first();
        if (!$user) {
            return response()->json(['error' => 'Refresh token non valido'], 401);
        }
        //crea un nuovo refreshtoken da mettere nel make, altrimenti utilizzi lo stesso di prima
        $newRefreshToken = Str::random(60);
        $cookie = Cookie::make(
            'refresh_token',
            $newRefreshToken,
            60 * 24 * 7,
            '/',
            null,
            true,
            true
        );
        $token = Auth::guard('api')->tokenbyID($user->id);
        return $this->respondWithTokenCookie($token, $cookie);
    }
}
