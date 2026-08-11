<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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
