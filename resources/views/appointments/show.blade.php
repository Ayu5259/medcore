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

    {{-- Success message --}}
    @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
    @endif

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


    {{-- Appointment actions --}}
    <div>

        {{-- Edit Appointment --}}
        @can('update', $appointment)
        @if (!in_array($appointment->status, ['cancelled', 'completed']))
        <a href="{{ route('appointments.edit', $appointment) }}">
            Edit Appointment
        </a>
        @endif
        @endcan


        {{-- Cancel Appointment --}}
        @can('cancel', $appointment)
        @if (in_array($appointment->status, ['pending', 'confirmed']))
        <form
            method="POST"
            action="{{ route('appointments.cancel', $appointment) }}">
            @csrf
            @method('PATCH')

            <button type="submit">
                Cancel Appointment
            </button>
        </form>
        @endif
        @endcan


        {{-- Create Visit Report --}}
        @can('create', [\App\Models\VisitReport::class, $appointment])
        @if (!$appointment->visitReport)
        <a href="{{ route('visit-reports.create', $appointment) }}">
            Create Visit Report
        </a>
        @endif
        @endcan


        {{-- View Visit Report --}}
        @if ($appointment->visitReport)
        @can('view', $appointment->visitReport)
        <a href="{{ route('visit-reports.show', $appointment->visitReport) }}">
            View Visit Report
        </a>
        @endcan
        @endif

    </div>

</body>

</html>