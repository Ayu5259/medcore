@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="container-fluid py-2">

    <div class="mb-4">
        <h2 class="mb-1">My Profile</h2>

        <p class="text-muted mb-0">
            Manage your personal and professional information.
        </p>
    </div>


    @if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    @endif


    <div class="row g-4">

        {{-- Personal Information --}}

        <div class="col-lg-6">

            <div class="card shadow-sm h-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        Personal Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <strong>Name:</strong>

                        {{ $user->first_name }}
                        {{ $user->last_name }}
                    </div>

                    <div class="mb-3">
                        <strong>Email:</strong>

                        {{ $user->email }}
                    </div>

                    <div class="mb-3">
                        <strong>Phone:</strong>

                        {{ $user->phone ?? 'Not provided' }}
                    </div>

                    <div class="mb-3">
                        <strong>Gender:</strong>

                        {{ $user->gender ?? 'Not provided' }}
                    </div>

                    <div class="mb-3">
                        <strong>Birth Date:</strong>

                        {{ $user->birth_date?->format('Y-m-d') ?? 'Not provided' }}
                    </div>

                    <div class="mb-3">
                        <strong>Address:</strong>

                        {{ $user->address ?? 'Not provided' }}
                    </div>

                </div>

            </div>

        </div>


        {{-- Professional Information --}}

        <div class="col-lg-6">

            <div class="card shadow-sm h-100">

                <div class="card-header">
                    <h5 class="mb-0">
                        Professional Information
                    </h5>
                </div>

                <div class="card-body">

                    @if($user->doctor)

                    <div class="mb-3">
                        <strong>Medical License:</strong>

                        {{ $user->doctor->medical_license ?? 'Not provided' }}
                    </div>

                    <div class="mb-3">
                        <strong>Experience:</strong>

                        {{ $user->doctor->experience_year ?? 0 }}
                        years
                    </div>

                    <div class="mb-3">
                        <strong>Specialty:</strong>

                        {{ $user->doctor->specialty?->name ?? 'Not assigned' }}
                    </div>

                    <div class="mb-3">
                        <strong>Department:</strong>

                        {{ $user->doctor->department?->name ?? 'Not assigned' }}
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


    {{-- Edit Button --}}

    <div class="mt-4">

        <a href="{{ route('profile.edit') }}"
            class="btn btn-primary">

            Edit Profile

        </a>

    </div>

</div>

@endsection