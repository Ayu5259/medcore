<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Prescription #{{ $prescription->id }}
    </title>
</head>

<body>

    <h1>
        Prescription #{{ $prescription->id }}
    </h1>


    <h2>Appointment</h2>

    <p>
        <strong>Appointment ID:</strong>
        {{ $prescription->appointment->id }}
    </p>

    <p>
        <strong>Date:</strong>
        {{ $prescription->appointment->appointment_date->format('Y-m-d') }}
    </p>


    <h2>Doctor</h2>

    <p>
        {{ $prescription->appointment->doctor->user->first_name }}
        {{ $prescription->appointment->doctor->user->last_name }}
    </p>


    <h2>Patient</h2>

    <p>
        {{ $prescription->appointment->patient->user->first_name }}
        {{ $prescription->appointment->patient->user->last_name }}
    </p>


    <h2>Medicines</h2>

    @forelse ($prescription->prescriptionItems as $item)

    <article>

        <h3>
            {{ $item->medicine->name }}
        </h3>

        <p>
            <strong>Generic Name:</strong>
            {{ $item->medicine->generic_name }}
        </p>

        <p>
            <strong>Manufacturer:</strong>
            {{ $item->medicine->manufacturer }}
        </p>

        <p>
            <strong>Dosage Form:</strong>
            {{ $item->medicine->dosage_form }}
        </p>

        <p>
            <strong>Dosage:</strong>
            {{ $item->dosage }}
        </p>

        <p>
            <strong>Frequency:</strong>
            {{ $item->frequency }}
        </p>

        <p>
            <strong>Duration:</strong>
            {{ $item->duration }}
        </p>

        <p>
            <strong>Instructions:</strong>
            {{ $item->instructions ?? 'N/A' }}
        </p>

        <hr>

    </article>

    @empty

    <p>
        No medicines found.
    </p>

    @endforelse


    @can('update', $prescription)

    <p>
        <a href="{{ route('prescriptions.edit', $prescription) }}">
            Edit Prescription
        </a>
    </p>

    @endcan


    <p>
        <a href="{{ route('appointments.index') }}">
            Back to Appointments
        </a>
    </p>

</body>

</html>