<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $remember = $request->has('remember');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return redirect('/users');
        }
        return back()->withErrors(['Credenziali errate']);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();       //session.flush non sti due
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
