{{-- resources/views/visit_reports/create.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    {{-- Make the page responsive on different screen sizes. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Visit Report</title>
</head>

<body>

    <h1>Create Visit Report</h1>

    {{-- Appointment information --}}
    <div>
        <h2>Appointment #{{ $appointment->id }}</h2>

        <p>
            <strong>Patient:</strong>

            {{ $appointment->patient->user->first_name }}
            {{ $appointment->patient->user->last_name }}
        </p>

        <p>
            <strong>Date:</strong>

            {{ $appointment->appointment_date->format('Y-m-d') }}
        </p>

        <p>
            <strong>Time:</strong>

            {{ $appointment->appointment_start_time }}
            -
            {{ $appointment->appointment_end_time }}
        </p>

        <p>
            <strong>Reason:</strong>

            {{ $appointment->reason }}
        </p>
    </div>


    {{-- Visit report form --}}
    <form
        method="POST"
        action="{{ route('visit-reports.store', $appointment) }}">

        @csrf

        {{-- Symptoms --}}
        <div>
            <label for="symptoms">
                Symptoms
            </label>

            <textarea
                id="symptoms"
                name="symptoms"
                rows="4">{{ old('symptoms') }}</textarea>

            @error('symptoms')
            <div>
                {{ $message }}
            </div>
            @enderror
        </div>


        {{-- Diagnosis --}}
        <div>
            <label for="diagnosis">
                Diagnosis
            </label>

            <textarea
                id="diagnosis"
                name="diagnosis"
                rows="4">{{ old('diagnosis') }}</textarea>

            @error('diagnosis')
            <div>
                {{ $message }}
            </div>
            @enderror
        </div>


        {{-- Blood pressure --}}
        <div>
            <label for="blood_pressure">
                Blood Pressure
            </label>

            <input
                type="text"
                id="blood_pressure"
                name="blood_pressure"
                value="{{ old('blood_pressure') }}">

            @error('blood_pressure')
            <div>
                {{ $message }}
            </div>
            @enderror
        </div>


        {{-- Temperature --}}
        <div>
            <label for="temperature">
                Temperature
            </label>

            <input
                type="number"
                step="0.1"
                id="temperature"
                name="temperature"
                value="{{ old('temperature') }}">

            @error('temperature')
            <div>
                {{ $message }}
            </div>
            @enderror
        </div>


        {{-- Heart rate --}}
        <div>
            <label for="heart_rate">
                Heart Rate
            </label>

            <input
                type="number"
                id="heart_rate"
                name="heart_rate"
                value="{{ old('heart_rate') }}">

            @error('heart_rate')
            <div>
                {{ $message }}
            </div>
            @enderror
        </div>


        {{-- Notes --}}
        <div>
            <label for="notes">
                Notes
            </label>

            <textarea
                id="notes"
                name="notes"
                rows="4">{{ old('notes') }}</textarea>

            @error('notes')
            <div>
                {{ $message }}
            </div>
            @enderror
        </div>


        {{-- Form actions --}}
        <div>
            <button type="submit">
                Create Visit Report
            </button>

            <a href="{{ route('appointments.show', $appointment) }}">
                Cancel
            </a>
        </div>

    </form>

</body>

</html>