<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Medical Record Entry</title>
</head>

<body>

    <h1>Create Medical Record Entry</h1>

    @if ($errors->any())
    <div>
        <strong>Please fix the following errors:</strong>

        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form
        method="POST"
        action="{{ route('medical-record-entries.store') }}">

        @csrf

        <div>
            <label for="appointment_id">
                Appointment
            </label>

            <select
                name="appointment_id"
                id="appointment_id"
                required>
                <option value="">
                    Select an appointment
                </option>

                @foreach ($appointments as $appointment)
                <option
                    value="{{ $appointment->id }}"
                    @selected(old('appointment_id')==$appointment->id)
                    >
                    Appointment #{{ $appointment->id }}
                    -
                    Patient #{{ $appointment->patient_id }}
                    -
                    {{ $appointment->appointment_date?->format('Y-m-d') }}
                </option>
                @endforeach
            </select>
        </div>

        <br>

        <div>
            <label for="diagnosis">
                Diagnosis
            </label>

            <textarea
                name="diagnosis"
                id="diagnosis"
                required>{{ old('diagnosis') }}</textarea>
        </div>

        <br>

        <div>
            <label for="treatment">
                Treatment
            </label>

            <textarea
                name="treatment"
                id="treatment">{{ old('treatment') }}</textarea>
        </div>

        <br>

        <div>
            <label for="notes">
                Notes
            </label>

            <textarea
                name="notes"
                id="notes">{{ old('notes') }}</textarea>
        </div>

        <br>

        <button type="submit">
            Create Entry
        </button>

    </form>

</body>

</html>