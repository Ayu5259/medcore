<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function show()
    {
        $user = User::findOrFail(Auth::id());
        $user->load([
            'doctor.specialty',
            'doctor.department',
        ]);

        return view(
            'profile.show',
            compact('user')
        );
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id,
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'gender' => [
                'nullable',
                'string',
                'max:20',
            ],

            'birth_date' => [
                'nullable',
                'date',
            ],

            'country' => [
                'nullable',
                'string',
                'max:100',
            ],

            'province' => [
                'nullable',
                'string',
                'max:100',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'postal_code' => [
                'nullable',
                'string',
                'max:20',
            ],
        ]);

        $user->update($validated);

        return redirect()
            ->route('profile.show')
            ->with(
                'success',
                'Profile updated successfully.'
            );
    }

    public function edit()
    {
        $user = User::findOrFail(Auth::id());

        return view(
            'profile.edit',
            compact('user')
        );
    }
}
