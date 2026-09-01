{{-- resources/views/visit_reports/show.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    {{-- Make the page responsive on different screen sizes. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Visit Report #{{ $visitReport->id }}</title>
</head>

<body>

    <h1>Visit Report #{{ $visitReport->id }}</h1>

    {{-- Appointment information --}}
    <div>
        <h2>Appointment Information</h2>

        <p>
            <strong>Patient:</strong>

            {{ $visitReport->appointment->patient->user->first_name }}
            {{ $visitReport->appointment->patient->user->last_name }}
        </p>

        <p>
            <strong>Doctor:</strong>

            {{ $visitReport->appointment->doctor->user->first_name }}
            {{ $visitReport->appointment->doctor->user->last_name }}
        </p>

        <p>
            <strong>Date:</strong>

            {{ $visitReport->appointment->appointment_date->format('Y-m-d') }}
        </p>

        <p>
            <strong>Time:</strong>

            {{ $visitReport->appointment->appointment_start_time }}
            -
            {{ $visitReport->appointment->appointment_end_time }}
        </p>
    </div>


    {{-- Visit report information --}}
    <div>
        <h2>Medical Information</h2>

        <p>
            <strong>Symptoms:</strong>

            {{ $visitReport->symptoms ?? 'Not provided.' }}
        </p>

        <p>
            <strong>Diagnosis:</strong>

            {{ $visitReport->diagnosis ?? 'Not provided.' }}
        </p>

        <p>
            <strong>Blood Pressure:</strong>

            {{ $visitReport->blood_pressure ?? 'Not provided.' }}
        </p>

        <p>
            <strong>Temperature:</strong>

            {{ $visitReport->temperature ?? 'Not provided.' }}
        </p>

        <p>
            <strong>Heart Rate:</strong>

            {{ $visitReport->heart_rate ?? 'Not provided.' }}
        </p>

        <p>
            <strong>Notes:</strong>

            {{ $visitReport->notes ?? 'No additional notes.' }}
        </p>
    </div>


    {{-- Actions --}}
    <div>

        {{-- Edit Visit Report --}}
        @can('update', $visitReport)
        <a href="{{ route('visit-reports.edit', $visitReport) }}">
            Edit Visit Report
        </a>
        @endcan

        {{-- Back to Appointment --}}
        <a href="{{ route('appointments.show', $visitReport->appointment) }}">
            Back to Appointment
        </a>

    </div>

</body>

</html>