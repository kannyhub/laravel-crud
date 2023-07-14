<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function login() {
        if (Auth::User()) {
            return Redirect::to(route('user.dashboard'));
        }
        return view('login');
    }

    public function authenticate(Request $request) {
        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email','password'))) {
            return Redirect::to(route('user.dashboard'));
        }
        return Redirect::to(route('auth.login'));
    }

    public function logout() {
        Auth::logout();
        return Redirect::to(route('auth.login'));
    }
}
