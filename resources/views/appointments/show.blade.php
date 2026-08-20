{{-- resources/views/appointments/show.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    {{-- Make the page responsive on different screen sizes. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Appointment #{{ $appointment->id }}</title>
</head>

<body>

    {{-- Page title --}}
    <h1>Appointment #{{ $appointment->id }}</h1>

    {{-- Doctor information --}}
    <div>
        <strong>Doctor:</strong>

        {{ $appointment->doctor->user->first_name }}
        {{ $appointment->doctor->user->last_name }}
    </div>

    {{-- Appointment date --}}
    <div>
        <strong>Date:</strong>

        {{ $appointment->appointment_date->format('Y-m-d') }}
    </div>

    {{-- Appointment time --}}
    <div>
        <strong>Time:</strong>

        {{ $appointment->appointment_start_time }}
        -
        {{ $appointment->appointment_end_time }}
    </div>

    {{-- Appointment reason --}}
    <div>
        <strong>Reason:</strong>

        {{ $appointment->reason }}
    </div>

    {{-- Visit type --}}
    <div>
        <strong>Visit Type:</strong>

        {{ $appointment->visit_type }}
    </div>

    {{-- Appointment status --}}
    <div>
        <strong>Status:</strong>

        {{ $appointment->status }}
    </div>

    {{-- Additional notes --}}
    <div>
        <strong>Notes:</strong>

        {{ $appointment->notes ?? 'No additional notes.' }}
    </div>

</body>

</html>