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
    $user = auth()->user();
    $role = $user?->role?->name;
    $currentRoute = Route::currentRouteName();

    $isDoctor = $role === 'Doctor';
    $isPatient = $role === 'Patient';
    $isAdmin = $role === 'Admin';
    @endphp


    {{-- Top Navbar --}}

    <nav class="navbar navbar-dark bg-dark shadow-sm">

        <div class="container-fluid">

            <a class="navbar-brand fw-semibold"
                href="{{ route('dashboard') }}">
                MediCore
            </a>


            <div class="d-flex align-items-center gap-3">

                <div class="text-end text-white">

                    <div class="fw-semibold">
                        {{ $user->first_name }}
                        {{ $user->last_name }}
                    </div>

                    <small class="text-light opacity-75">
                        {{ $role }}
                    </small>

                </div>


                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                        class="btn btn-outline-light btn-sm">
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </nav>



    {{-- Main Layout --}}

    <div class="container-fluid">

        <div class="row min-vh-100">


            {{-- Sidebar --}}

            <aside class="col-md-3 col-lg-2 bg-white border-end p-3">


                {{-- Dashboard --}}

                <div class="sidebar-menu">

                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link
                       {{ $currentRoute === 'dashboard'
                            ? 'active'
                            : '' }}">

                        Dashboard

                    </a>

                </div>



                {{------------------------------DOCTOR-----------------------------------------}}

                @if($isDoctor)
                {{-- Appointments --}}

                <div class="sidebar-section">

                    <button type="button"
                        class="sidebar-toggle"
                        data-menu="appointmentsMenu">

                        <span>Appointments</span>

                        <span class="sidebar-arrow">
                            ▾
                        </span>

                    </button>


                    <div id="appointmentsMenu"
                        class="sidebar-submenu">

                        <a href="{{ route('appointments.index') }}"
                            class="sidebar-sublink">

                            All Appointments

                        </a>


                        <a href="{{ route('appointments.create') }}"
                            class="sidebar-sublink">

                            Create Appointment

                        </a>

                    </div>

                </div>



                {{-- Patients --}}

                <div class="sidebar-section">

                    <button type="button"
                        class="sidebar-toggle"
                        data-menu="patientsMenu">

                        <span>Patients</span>

                        <span class="sidebar-arrow">
                            ▾
                        </span>

                    </button>


                    <div id="patientsMenu"
                        class="sidebar-submenu">

                        {{-- Route will be added later --}}

                        <span class="sidebar-sublink disabled">
                            My Patients
                        </span>


                        <span class="sidebar-sublink disabled">
                            Patient Medical Records
                        </span>

                    </div>

                </div>



                {{-- Medical Records --}}

                <div class="sidebar-section">

                    <a href="{{ route('medical_records.index') }}"
                        class="sidebar-link
                           {{ str_starts_with($currentRoute ?? '', 'medical_records.')
                                ? 'active'
                                : '' }}">

                        Medical Records

                    </a>

                </div>



                {{-- Prescriptions --}}

                <div class="sidebar-section">

                    <button type="button"
                        class="sidebar-toggle"
                        data-menu="prescriptionsMenu">

                        <span>Prescriptions</span>

                        <span class="sidebar-arrow">
                            ▾
                        </span>

                    </button>


                    <div id="prescriptionsMenu"
                        class="sidebar-submenu">

                        <a href="{{ route('prescriptions.index') }}"
                            class="sidebar-sublink">

                            All Prescriptions

                        </a>


                        <a href="{{ route('prescriptions.create') }}"
                            class="sidebar-sublink">

                            Create Prescription

                        </a>

                    </div>

                </div>



                {{-- Finance --}}

                <div class="sidebar-section">

                    <button type="button"
                        class="sidebar-toggle"
                        data-menu="financeMenu">

                        <span>Finance</span>

                        <span class="sidebar-arrow">
                            ▾
                        </span>

                    </button>


                    <div id="financeMenu"
                        class="sidebar-submenu">

                        <a href="{{ route('payments.index') }}"
                            class="sidebar-sublink">

                            Payments

                        </a>


                        {{-- Route will be added later --}}

                        <span class="sidebar-sublink disabled">
                            Payment History
                        </span>

                    </div>

                </div>



                {{-- Account --}}


                <div class="sidebar-section">

                    {{-- Route will be added later --}}

                    <span class="sidebar-link disabled">
                        Profile
                    </span>

                </div>

                @endif



                {{---------------------------------------PATIENT-------------------------------------}}

                @if($isPatient)

                <div class="sidebar-section">

                    <a href="{{ route('appointments.index') }}"
                        class="sidebar-link">

                        Appointments

                    </a>


                    <a href="{{ route('medical_records.index') }}"
                        class="sidebar-link">

                        Medical Records

                    </a>


                    <a href="{{ route('prescriptions.index') }}"
                        class="sidebar-link">

                        Prescriptions

                    </a>

                </div>



                <div class="sidebar-section">

                    <a href="{{ route('payments.index') }}"
                        class="sidebar-link">

                        Payments

                    </a>

                </div>

                @endif



                {{------------------------------ADMIN----------------------------}}

                @if($isAdmin)

                <h6 class="text-muted mt-4 mb-3">
                    ADMINISTRATION
                </h6>


                <div class="sidebar-section">

                    <a href="{{ route('admin') }}"
                        class="sidebar-link">

                        Admin Panel

                    </a>

                </div>

                @endif

            </aside>



            {{-- Page Content --}}

            <main class="col-md-9 col-lg-10 p-4">

                @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

                @endif


                @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

                @endif


                @yield('content')

            </main>

        </div>

    </div>



    {{-- Sidebar JavaScript --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const buttons = document.querySelectorAll('.sidebar-toggle');


            buttons.forEach(function(button) {

                button.addEventListener('click', function() {

                    const menuId = button.dataset.menu;
                    const menu = document.getElementById(menuId);

                    if (!menu) {
                        return;
                    }


                    const isOpen = menu.classList.contains('show');


                    // Close all submenus

                    document.querySelectorAll('.sidebar-submenu.show')
                        .forEach(function(openMenu) {

                            openMenu.classList.remove('show');

                        });


                    document.querySelectorAll('.sidebar-toggle.open')
                        .forEach(function(openButton) {

                            openButton.classList.remove('open');

                        });


                    // Open selected submenu

                    if (!isOpen) {

                        menu.classList.add('show');
                        button.classList.add('open');

                    }

                });

            });

        });
    </script>

</body>

</html>