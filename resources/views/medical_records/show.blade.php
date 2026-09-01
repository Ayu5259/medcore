<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    ```
    <title>Medical Record</title>
    ```

</head>

<body>

    ```
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
            <strong>Doctor:</strong>

            {{ $entry->doctor->user->first_name }}
            {{ $entry->doctor->user->last_name }}
        </p>

        <p>
            <strong>Diagnosis:</strong>
            {{ $entry->diagnosis }}
        </p>

        <p>
            <strong>Treatment:</strong>
            {{ $entry->treatment ?? 'N/A' }}
        </p>

        <p>
            <strong>Notes:</strong>
            {{ $entry->notes ?? 'N/A' }}
        </p>

        <p>
            <strong>Date:</strong>
            {{ $entry->created_at->format('Y-m-d H:i') }}
        </p>

        <hr>

    </article>

    @empty

    <p>No medical history available.</p>

    @endforelse
    ```

</body>

</html>