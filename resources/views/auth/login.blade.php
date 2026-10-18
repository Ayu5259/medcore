@extends('layouts.guest')

@section('title', 'Login | MediCore')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row align-items-center justify-content-center g-5">

            <div class="col-lg-5 d-none d-lg-block">
                <div class="auth-intro">
                    <span class="auth-eyebrow">YOUR HEALTH, CONNECTED</span>

                    <h1>Healthcare made simpler.</h1>

                    <p>
                        Manage appointments, access medical records,
                        and stay connected with your healthcare team.
                    </p>

                    <div class="auth-feature">
                        <span class="feature-check">✓</span>
                        Convenient appointment management
                    </div>

                    <div class="auth-feature">
                        <span class="feature-check">✓</span>
                        Your healthcare information in one place
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-8 col-lg-5">
                <div class="auth-card">

                    <div class="auth-card-heading">
                        <span class="auth-eyebrow">WELCOME BACK</span>
                        <h2>Sign in to MediCore</h2>
                        <p>Enter your account details to continue.</p>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                Email address
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control auth-input @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                autocomplete="email"
                                required
                                autofocus>

                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control auth-input @error('password') is-invalid @enderror"
                                placeholder="Enter your password"
                                autocomplete="current-password"
                                required>

                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary auth-submit w-100">
                            Sign In
                        </button>
                    </form>

                    <div class="auth-switch">
                        Don't have an account?
                        <a href="{{ route('register') }}">Create an account</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection