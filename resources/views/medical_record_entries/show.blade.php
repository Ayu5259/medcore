<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Medical Record Entry</title>
</head>

<body>

    <h1>Medical Record Entry</h1>

    @if (session('success'))
    <p>
        {{ session('success') }}
    </p>
    @endif

    <p>
        <strong>Entry ID:</strong>
        {{ $medicalRecordEntry->id }}
    </p>

    <p>
        <strong>Medical Record ID:</strong>
        {{ $medicalRecordEntry->medical_record_id }}
    </p>

    <p>
        <strong>Appointment ID:</strong>
        {{ $medicalRecordEntry->appointment_id }}
    </p>

    <p>
        <strong>Doctor ID:</strong>
        {{ $medicalRecordEntry->doctor_id }}
    </p>

    <h2>Diagnosis</h2>
    <p>
        {{ $medicalRecordEntry->diagnosis }}
    </p>

    <h2>Treatment</h2>
    <p>
        {{ $medicalRecordEntry->treatment }}
    </p>

    <h2>Notes</h2>
    <p>
        {{ $medicalRecordEntry->notes }}
    </p>

</body>

</html>