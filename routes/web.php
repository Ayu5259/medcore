<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


// Show the login form
Route::get('/login', [LoginController::class, 'showLoginForm']);

// Process login request
Route::post('/login', [LoginController::class, 'login']);

// Show the registration form
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
    ->name('register');

// Process registration request
Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.store');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');
