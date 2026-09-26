<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MediCore')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-light">
    @php
    $role = auth()->user()->role->name;
    @endphp

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                MediCore
            </a>

            <div class="d-flex align-items-center gap-3">

                <div class="text-end text-white">

                    <div>
                        {{ auth()->user()->first_name }}
                        {{ auth()->user()->last_name }}
                    </div>

                    <small class="text-light opacity-75">
                        {{ auth()->user()->role->name }}
                    </small>

                </div>


                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="btn btn-outline-light btn-sm">
                        Logout
                    </button>

                </form>

            </div>

        </div>
    </nav>


    <div class="container-fluid">

        <div class="row min-vh-100">

            <aside class="col-md-3 col-lg-2 bg-white border-end p-3">

                <h6 class="text-muted mb-3">
                    MENU
                </h6>


                <div class="nav flex-column gap-1">

                    <a href="{{ route('dashboard') }}"
                        class="nav-link text-dark">
                        Dashboard
                    </a>

                </div>

                <h6 class="text-muted mt-4 mb-3">
                    CLINICAL
                </h6>


                <div class="nav flex-column gap-1">

                    @if(in_array($role, ['Admin', 'Doctor', 'Patient']))

                    <a href="{{ route('appointments.index') }}"
                        class="nav-link text-dark">
                        Appointments
                    </a>

                    @endif


                    @if(in_array($role, ['Admin', 'Doctor', 'Patient']))

                    <a href="{{ route('medical_records.index') }}"
                        class="nav-link text-dark">
                        Medical Records
                    </a>

                    @endif


                    @if(in_array($role, ['Admin', 'Doctor', 'Patient']))

                    <a href="{{ route('prescriptions.index') }}"
                        class="nav-link text-dark">
                        Prescriptions
                    </a>

                    @endif

                </div>

                <h6 class="text-muted mt-4 mb-3">
                    FINANCE
                </h6>


                <div class="nav flex-column gap-1">

                    @if(in_array($role, ['Admin', 'Patient']))
                    <a href="{{ route('payments.index') }}"
                        class="nav-link text-dark">
                        Payments
                    </a>
                    @endif

                </div>


            </aside>

            <main class="col-md-9 col-lg-10 p-4">

                @yield('content')

            </main>

        </div>

    </div>

</body>

</html>