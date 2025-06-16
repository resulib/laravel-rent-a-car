<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::user()->is_admin) {
            return redirect()->intended(route('admin.dashboard'));
        }
        return redirect(route('login'))->with("error", 'Invalid email or password');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
