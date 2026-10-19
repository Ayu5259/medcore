@extends('layouts.guest')

@section('title', 'Create Account | MediCore')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">

            {{-- Page heading --}}
            <div class="text-center mb-4">
                <span class="badge text-bg-primary mb-3">
                    Patient Registration
                </span>

                <h1 class="fw-bold">Create your MediCore account</h1>

                <p class="text-secondary">
                    Enter your information to create your patient account.
                </p>
            </div>

            {{-- Validation errors --}}
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h6 class="alert-heading fw-bold">
                    Please check the following information:
                </h6>

                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        {{-- Personal information --}}
                        <h5 class="fw-bold mb-3">Personal Information</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">
                                    First Name *
                                </label>

                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name') }}"
                                    autocomplete="given-name"
                                    required>

                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="last_name" class="form-label">
                                    Last Name *
                                </label>

                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name') }}"
                                    autocomplete="family-name"
                                    required>

                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="national_code" class="form-label">
                                    National Code *
                                </label>

                                <input
                                    type="text"
                                    id="national_code"
                                    name="national_code"
                                    class="form-control @error('national_code') is-invalid @enderror"
                                    value="{{ old('national_code') }}"
                                    inputmode="numeric"
                                    maxlength="10"
                                    required>

                                @error('national_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="gender" class="form-label">
                                    Gender *
                                </label>

                                <select
                                    id="gender"
                                    name="gender"
                                    class="form-select @error('gender') is-invalid @enderror"
                                    required>
                                    <option value="">Select gender</option>
                                    <option value="Male" @selected(old('gender')==='Male' )>
                                        Male
                                    </option>
                                    <option value="Female" @selected(old('gender')==='Female' )>
                                        Female
                                    </option>
                                    <option value="NonBinary" @selected(old('gender')==='NonBinary' )>
                                        Non-binary
                                    </option>
                                </select>

                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="birth_date" class="form-label">
                                    Birth Date
                                </label>

                                <input
                                    type="date"
                                    id="birth_date"
                                    name="birth_date"
                                    class="form-control @error('birth_date') is-invalid @enderror"
                                    value="{{ old('birth_date') }}">

                                @error('birth_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">
                                    Phone Number *
                                </label>

                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                    placeholder="09123456789"
                                    autocomplete="tel"
                                    inputmode="numeric"
                                    maxlength="11"
                                    required>

                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Address information --}}
                        <h5 class="fw-bold mb-3">Address Information</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="country" class="form-label">
                                    Country
                                </label>

                                <input
                                    type="text"
                                    id="country"
                                    name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ old('country') }}"
                                    autocomplete="country-name">

                                @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="province" class="form-label">
                                    Province *
                                </label>

                                <select
                                    id="province"
                                    name="province"
                                    class="form-select @error('province') is-invalid @enderror"
                                    required>
                                    <option value="">Select province</option>
                                    <option value="Tehran" @selected(old('province')==='Tehran' )>
                                        Tehran
                                    </option>
                                    <option value="Alborz" @selected(old('province')==='Alborz' )>
                                        Alborz
                                    </option>
                                    <option value="Isfahan" @selected(old('province')==='Isfahan' )>
                                        Isfahan
                                    </option>
                                    <option value="Fars" @selected(old('province')==='Fars' )>
                                        Fars
                                    </option>
                                </select>

                                @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="city" class="form-label">City</label>

                                <select
                                    id="city"
                                    name="city"
                                    class="form-select @error('city') is-invalid @enderror">
                                    <option value="">Select city</option>
                                    <option value="Tehran" @selected(old('city')==='Tehran' )>
                                        Tehran
                                    </option>
                                    <option value="Karaj" @selected(old('city')==='Karaj' )>
                                        Karaj
                                    </option>
                                    <option value="Isfahan" @selected(old('city')==='Isfahan' )>
                                        Isfahan
                                    </option>
                                    <option value="Shiraz" @selected(old('city')==='Shiraz' )>
                                        Shiraz
                                    </option>
                                </select>

                                @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="postal_code" class="form-label">
                                    Postal Code
                                </label>

                                <input
                                    type="text"
                                    id="postal_code"
                                    name="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code') }}"
                                    inputmode="numeric"
                                    maxlength="10">

                                @error('postal_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="street" class="form-label">Street</label>

                                <input
                                    type="text"
                                    id="street"
                                    name="street"
                                    class="form-control @error('street') is-invalid @enderror"
                                    value="{{ old('street') }}">

                                @error('street')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="alley" class="form-label">Alley</label>

                                <input
                                    type="text"
                                    id="alley"
                                    name="alley"
                                    class="form-control @error('alley') is-invalid @enderror"
                                    value="{{ old('alley') }}">

                                @error('alley')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="plaque" class="form-label">
                                    Building Number
                                </label>

                                <input
                                    type="text"
                                    id="plaque"
                                    name="plaque"
                                    class="form-control @error('plaque') is-invalid @enderror"
                                    value="{{ old('plaque') }}">

                                @error('plaque')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="unit" class="form-label">Unit</label>

                                <input
                                    type="text"
                                    id="unit"
                                    name="unit"
                                    class="form-control @error('unit') is-invalid @enderror"
                                    value="{{ old('unit') }}">

                                @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Account information --}}
                        <h5 class="fw-bold mb-3">Account Information</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email *</label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required>

                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email_confirmation" class="form-label">
                                    Confirm Email *
                                </label>

                                <input
                                    type="email"
                                    id="email_confirmation"
                                    name="email_confirmation"
                                    class="form-control @error('email_confirmation') is-invalid @enderror"
                                    value="{{ old('email_confirmation') }}"
                                    required>

                                @error('email_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    Password *
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password"
                                    minlength="8"
                                    required>

                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <div class="form-text">
                                    Use at least 8 characters.
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    Confirm Password *
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    autocomplete="new-password"
                                    minlength="8"
                                    required>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Create Account
                            </button>
                        </div>

                        <p class="text-center text-secondary mt-4 mb-0">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">
                                Sign in
                            </a>
                        </p>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection