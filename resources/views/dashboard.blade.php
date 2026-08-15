<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MediCore Dashboard</title>
</head>

<body>

    <h1>Welcome to MediCore</h1>

    <h2>
        {{ $user->first_name }} {{ $user->last_name }}
    </h2>

    <p>Email: {{ $user->email }}</p>

    <p>Role ID: {{ $user->role_id }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</body>

</html>