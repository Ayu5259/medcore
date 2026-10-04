@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="container-fluid py-2">

    <div class="mb-4">

        <h2 class="mb-1">
            Edit Profile
        </h2>

        <p class="text-muted mb-0">
            Update your personal information.
        </p>

    </div>


    @if($errors->any())

    <div class="alert alert-danger">

        <strong>
            Please fix the following errors:
        </strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

            @endforeach

        </ul>

    </div>

    @endif


    <form
        method="POST"
        action="{{ route('profile.update') }}">

        @csrf
        @method('PUT')


        <div class="row g-4">


            {{-- Personal Information --}}

            <div class="col-lg-8">

                <div class="card shadow-sm">

                    <div class="card-header">

                        <h5 class="mb-0">
                            Personal Information
                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="row g-3">


                            {{-- First Name --}}

                            <div class="col-md-6">

                                <label
                                    for="first_name"
                                    class="form-label">
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    class="form-control"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    required>

                            </div>


                            {{-- Last Name --}}

                            <div class="col-md-6">

                                <label
                                    for="last_name"
                                    class="form-label">
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    class="form-control"
                                    value="{{ old('last_name', $user->last_name) }}"
                                    required>

                            </div>


                            {{-- Email --}}

                            <div class="col-md-6">

                                <label
                                    for="email"
                                    class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email', $user->email) }}"
                                    required>

                            </div>


                            {{-- Phone --}}

                            <div class="col-md-6">

                                <label
                                    for="phone"
                                    class="form-label">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone', $user->phone) }}">

                            </div>


                            {{-- Gender --}}

                            <div class="col-md-6">

                                <label
                                    for="gender"
                                    class="form-label">
                                    Gender
                                </label>

                                <select
                                    id="gender"
                                    name="gender"
                                    class="form-select">

                                    <option value="">
                                        Select Gender
                                    </option>

                                    <option
                                        value="male"
                                        @selected(old('gender', $user->gender) === 'male')
                                        >
                                        Male
                                    </option>

                                    <option
                                        value="female"
                                        @selected(old('gender', $user->gender) === 'female')
                                        >
                                        Female
                                    </option>

                                </select>

                            </div>


                            {{-- Birth Date --}}

                            <div class="col-md-6">

                                <label
                                    for="birth_date"
                                    class="form-label">
                                    Birth Date
                                </label>

                                <input
                                    type="date"
                                    id="birth_date"
                                    name="birth_date"
                                    class="form-control"
                                    value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}">

                            </div>


                            {{-- Country --}}

                            <div class="col-md-4">

                                <label
                                    for="country"
                                    class="form-label">
                                    Country
                                </label>

                                <input
                                    type="text"
                                    id="country"
                                    name="country"
                                    class="form-control"
                                    value="{{ old('country', $user->country) }}">

                            </div>


                            {{-- Province --}}

                            <div class="col-md-4">

                                <label
                                    for="province"
                                    class="form-label">
                                    Province
                                </label>

                                <input
                                    type="text"
                                    id="province"
                                    name="province"
                                    class="form-control"
                                    value="{{ old('province', $user->province) }}">

                            </div>


                            {{-- City --}}

                            <div class="col-md-4">

                                <label
                                    for="city"
                                    class="form-label">
                                    City
                                </label>

                                <input
                                    type="text"
                                    id="city"
                                    name="city"
                                    class="form-control"
                                    value="{{ old('city', $user->city) }}">

                            </div>


                            {{-- Address --}}

                            <div class="col-12">

                                <label
                                    for="address"
                                    class="form-label">
                                    Address
                                </label>

                                <textarea
                                    id="address"
                                    name="address"
                                    rows="3"
                                    class="form-control">{{ old('address', $user->address) }}</textarea>

                            </div>


                            {{-- Postal Code --}}

                            <div class="col-md-6">

                                <label
                                    for="postal_code"
                                    class="form-label">
                                    Postal Code
                                </label>

                                <input
                                    type="text"
                                    id="postal_code"
                                    name="postal_code"
                                    class="form-control"
                                    value="{{ old('postal_code', $user->postal_code) }}">

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Professional Information --}}

            <div class="col-lg-4">

                <div class="card shadow-sm">

                    <div class="card-header">

                        <h5 class="mb-0">
                            Professional Information
                        </h5>

                    </div>


                    <div class="card-body">

                        @if($user->doctor)

                        <div class="mb-3">

                            <label class="form-label">
                                Medical License
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $user->doctor->medical_license ?? 'Not provided' }}"
                                disabled>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Experience
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $user->doctor->experience_year ?? 0 }} years"
                                disabled>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Specialty
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $user->doctor->specialty?->name ?? 'Not assigned' }}"
                                disabled>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Department
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $user->doctor->department?->name ?? 'Not assigned' }}"
                                disabled>

                        </div>

                        @else

                        <div class="alert alert-warning mb-0">
                            Doctor profile not found.
                        </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>


        {{-- Actions --}}

        <div class="mt-4">

            <button
                type="submit"
                class="btn btn-primary">
                Save Changes
            </button>

            <a
                href="{{ route('profile.show') }}"
                class="btn btn-outline-secondary ms-2">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection