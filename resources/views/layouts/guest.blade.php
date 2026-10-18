<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'MediCore')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="guest-body">

    <nav class="navbar navbar-expand-lg guest-navbar">
        <div class="container">
            <a class="navbar-brand guest-brand" href="/">
                <span class="brand-mark">M</span>
                MediCore
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="{{ route('login') }}"
                    class="btn btn-outline-primary btn-sm px-3">
                    Login
                </a>

                <a href="{{ route('register') }}"
                    class="btn btn-primary btn-sm px-3">
                    Get Started
                </a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="guest-footer">
        <div class="container text-center">
            <small>© {{ date('Y') }} MediCore. All rights reserved.</small>
        </div>
    </footer>

</body>

</html>