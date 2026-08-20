{{-- resources/views/appointments/index.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    {{-- Make the page responsive on different screen sizes. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Appointments</title>
</head>

<body>

    {{-- Page title --}}
    <h1>My Appointments</h1>

    {{-- Link to create a new appointment --}}
    <a href="{{ route('appointments.create') }}">
        Create New Appointment
    </a>

    {{-- Check whether the patient has any appointments. --}}
    @if ($appointments->isEmpty())

    <p>You do not have any appointments yet.</p>

    @else

    {{-- Display the patient's appointments. --}}
    @foreach ($appointments as $appointment)

    <div>
        <h2>
            Appointment #{{ $appointment->id }}
        </h2>

        {{-- Doctor name --}}
        <p>
            <strong>Doctor:</strong>

            {{ $appointment->doctor->user->first_name }}
            {{ $appointment->doctor->user->last_name }}
        </p>

        {{-- Appointment date --}}
        <p>
            <strong>Date:</strong>

            {{ $appointment->appointment_date->format('Y-m-d') }}
        </p>

        {{-- Appointment time --}}
        <p>
            <strong>Time:</strong>

            {{ $appointment->appointment_start_time }}
            -
            {{ $appointment->appointment_end_time }}
        </p>

        {{-- Appointment status --}}
        <p>
            <strong>Status:</strong>

            {{ $appointment->status }}
        </p>

        {{-- Link to appointment details --}}
        <a href="{{ route('appointments.show', $appointment) }}">
            View Appointment
        </a>
    </div>

    <hr>

    @endforeach

    @endif

</body>

</html>