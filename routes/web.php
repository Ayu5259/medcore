<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


// Authentication Routes

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


// Logout
// Only authenticated users can logout.
Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');


// Dashboard

// Dashboard is available to all authenticated users.
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


// Admin Routes

// Only users with the admin role can access the admin panel.
Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin');


// Medical Routes

// Doctors and nurses can access the medical area.
Route::get('/medical-area', function () {
    return 'Medical area';
})->middleware(['auth', 'role:doctor,nurse'])
    ->name('medical.area');


// Appointment Routes

// Display a specific appointment.
// Authorization is handled by AppointmentPolicy.
Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])
    ->middleware('auth')
    ->name('appointments.show');

// Display the authenticated patient's appointment list.
Route::get('/appointments', [AppointmentController::class, 'index'])
    ->middleware('auth')
    ->name('appointments.index');

// Display the appointment creation form.
// This route requires the user to be authenticated.
Route::get('/appointments/create', [AppointmentController::class, 'create'])
    ->middleware('auth')
    ->name('appointments.create');

// Store a newly created appointment.
// This route requires the user to be authenticated.
Route::post('/appointments', [AppointmentController::class, 'store'])
    ->middleware('auth')
    ->name('appointments.store');
