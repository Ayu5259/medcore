<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class RegisterController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Process the registration request
    public function register(Request $request)
    {

        // Validate the registration data
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'national_code' => ['required', 'string', 'size:10', 'unique:users,national_code'],
            'gender' => ['required', 'in:Male,Female,NonBinary'],
            'birth_date' => ['nullable', 'date'],
            'phone' => ['required', 'string', 'size:11'],

            // Validate the address fields
            'country' => ['nullable', 'string', 'max:255'],
            'province' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'street' => ['nullable', 'string', 'max:255'],
            'alley' => ['nullable', 'string', 'max:255'],
            'plaque' => ['nullable', 'string', 'max:50'],
            'unit' => ['nullable', 'string', 'max:50'],
            'postal_code' => ['nullable', 'string', 'max:20'],

            'email' => ['required', 'email', 'unique:users,email'],
            'email_confirmation' => ['required', 'same:email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        // Remove confirmation fields that are not stored in the database
        unset($validated['email_confirmation']);

        // Hash the user's password before storing it
        $validated['password'] = Hash::make($validated['password']);

        // Find the Patient role
        $patientRole = Role::where('name', 'Patient')->firstOrFail();

        // Assign the Patient role to the new user
        $validated['role_id'] = $patientRole->id;

        // Create a new user with the validated data
        $user = User::create($validated);

        // Display the data for testing
        dd($validated);
    }
}
