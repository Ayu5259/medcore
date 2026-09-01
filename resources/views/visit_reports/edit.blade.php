{{-- resources/views/visit_reports/edit.blade.php --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    {{-- Make the page responsive on different screen sizes. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Visit Report #{{ $visitReport->id }}</title>
</head>

<body>

    <h1>Edit Visit Report #{{ $visitReport->id }}</h1>

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


    {{-- Visit report form --}}
    <form
        method="POST"
        action="{{ route('visit-reports.update', $visitReport) }}">

        @csrf
        @method('PUT')

        {{-- Symptoms --}}
        <div>
            <label for="symptoms">
                Symptoms
            </label>

            <textarea
                id="symptoms"
                name="symptoms"
                rows="4">{{ old('symptoms', $visitReport->symptoms) }}</textarea>

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
                rows="4">{{ old('diagnosis', $visitReport->diagnosis) }}</textarea>

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
                value="{{ old('blood_pressure', $visitReport->blood_pressure) }}">

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
                value="{{ old('temperature', $visitReport->temperature) }}">

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
                value="{{ old('heart_rate', $visitReport->heart_rate) }}">

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
                rows="4">{{ old('notes', $visitReport->notes) }}</textarea>

            @error('notes')
            <div>
                {{ $message }}
            </div>
            @enderror
        </div>


        {{-- Form actions --}}
        <div>

            <button type="submit">
                Update Visit Report
            </button>

            <a href="{{ route('visit-reports.show', $visitReport) }}">
                Cancel
            </a>

        </div>

    </form>

</body>

</html>