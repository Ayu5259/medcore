<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // @desc  Show login form
    // @route GET /login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // @desc  Show login form
    // @route POST /login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        ///یا کاربری با این اطلاعات وجود دارد و پسوردش درست است؟
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return 'Login successful';
        }

        return 'Invalid email or password';
    }
}
