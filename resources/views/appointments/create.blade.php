<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    {{-- Make the page responsive on different screen sizes. --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Appointment</title>
</head>

<body>

    {{-- Page title --}}
    <h1>Create Appointment</h1>

    {{-- Display validation errors, if any exist. --}}
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

    {{-- Appointment creation form --}}
    <form action="{{ route('appointments.store') }}" method="POST">

        {{-- Laravel CSRF protection --}}
        @csrf

        @php
        $role = strtolower(auth()->user()->role->name ?? '');
        @endphp

        {{-- Patient selects the Doctor. --}}
        @if ($role === 'patient')

        <div>
            <label for="doctor_id">Doctor:</label>

            <select name="doctor_id" id="doctor_id" required>
                <option value="">Select a doctor</option>

                @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">
                    Dr. {{ $doctor->user->first_name }}
                    {{ $doctor->user->last_name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Doctor selects the Patient. --}}
        @elseif ($role === 'doctor')

        <div>
            <label for="patient_id">Patient:</label>

            <select name="patient_id" id="patient_id" required>
                <option value="">Select a patient</option>

                @foreach ($patients as $patient)
                <option value="{{ $patient->id }}">
                    {{ $patient->user->first_name }}
                    {{ $patient->user->last_name }}
                </option>
                @endforeach
            </select>
        </div>

        @endif

        {{-- Appointment date --}}
        <div>
            <label for="appointment_date">Date:</label>

            <input
                type="date"
                name="appointment_date"
                id="appointment_date"
                value="{{ old('appointment_date') }}"
                required>
        </div>

        {{-- Appointment start time --}}
        <div>
            <label for="appointment_start_time">Start Time:</label>

            <input
                type="time"
                name="appointment_start_time"
                id="appointment_start_time"
                value="{{ old('appointment_start_time') }}"
                required>
        </div>

        {{-- Appointment end time --}}
        <div>
            <label for="appointment_end_time">End Time:</label>

            <input
                type="time"
                name="appointment_end_time"
                id="appointment_end_time"
                value="{{ old('appointment_end_time') }}"
                required>
        </div>

        {{-- Reason for the appointment --}}
        <div>
            <label for="reason">Reason:</label>

            <input
                type="text"
                name="reason"
                id="reason"
                value="{{ old('reason') }}"
                required>
        </div>

        {{-- Type of visit --}}
        <div>
            <label for="visit_type">Visit Type:</label>

            <select name="visit_type" id="visit_type" required>
                <option value="">Select visit type</option>

                <option value="InPerson"
                    {{ old('visit_type') === 'InPerson' ? 'selected' : '' }}>
                    In Person
                </option>

                <option value="Online"
                    {{ old('visit_type') === 'Online' ? 'selected' : '' }}>
                    Online
                </option>

                <option value="Emergency"
                    {{ old('visit_type') === 'Emergency' ? 'selected' : '' }}>
                    Emergency
                </option>

                <option value="FollowUp"
                    {{ old('visit_type') === 'FollowUp' ? 'selected' : '' }}>
                    Follow Up
                </option>
            </select>
        </div>

        {{-- Additional notes --}}
        <div>
            <label for="notes">Notes:</label>

            <textarea
                name="notes"
                id="notes"
                rows="4">{{ old('notes') }}</textarea>
        </div>

        {{-- Submit the appointment request --}}
        <button type="submit">
            Create Appointment
        </button>

    </form>

</body>

</html>