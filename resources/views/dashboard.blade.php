@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-4">

    <h1 class="fw-bold">
        Welcome to MediCore
    </h1>

    <p class="text-muted mb-0">
        Welcome back, {{ $user->first_name }} {{ $user->last_name }}.
    </p>

</div>


<div class="row g-4">

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Role
                </h6>

                <h5 class="card-title">
                    {{ $user->role->name }}
                </h5>

                <p class="text-muted" class="mb-0">
                    Account Type
                </p>

            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Role
                </h6>

                <h3 class="card-title">
                    {{ $user->role_id }}
                </h3>

                <p class="text-muted mb-0">
                    Role ID
                </p>

            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Appointments
                </h6>

                <p class="text-muted mb-0">
                    Manage your appointments
                </p>

                <a href="{{ route('appointments.index') }}"
                    class="btn btn-primary btn-sm mt-3">
                    View Appointments
                </a>

            </div>

        </div>

    </div>


    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm h-100">

            <div class="card-body">

                <h6 class="text-muted">
                    Payments
                </h6>

                <p class="text-muted mb-0">
                    Manage your payments
                </p>

                <a href="{{ route('payments.index') }}"
                    class="btn btn-primary btn-sm mt-3">
                    View Payments
                </a>

            </div>

        </div>

    </div>

</div>

@endsection