<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Medical Record</title>
</head>

<body>

    <h1>Medical Record</h1>

    <h2>Patient</h2>

    <p>
        {{ $medicalRecord->patient->user->first_name }}
        {{ $medicalRecord->patient->user->last_name }}
    </p>

    <h2>Medical History</h2>

    @forelse ($medicalRecord->entries as $entry)

    <article>

        <p>
            <strong>Diagnosis:</strong>
            {{ $entry->diagnosis }}
        </p>

        <p>
            <strong>Treatment:</strong>
            {{ $entry->treatment }}
        </p>

        <p>
            <strong>Notes:</strong>
            {{ $entry->notes }}
        </p>

        <hr>

    </article>

    @empty

    <p>No medical history available.</p>

    @endforelse

</body>

</html>