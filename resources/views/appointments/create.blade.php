{{-- resources/views/appointments/create.blade.php --}}

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

        {{-- Doctor selection --}}
        <div>
            <label for="doctor_id">Doctor:</label>

            <select name="doctor_id" id="doctor_id" required>
                <option value="">Select a doctor</option>

                {{-- Loop through the doctors passed from AppointmentController --}}
                @foreach ($doctors as $doctor)
                <option value="{{ $doctor->id }}">
                    Dr. {{ $doctor->user->first_name }}
                    {{ $doctor->user->last_name }}
                </option>
                @endforeach
            </select>
        </div>

        {{-- Appointment date --}}
        <div>
            <label for="appointment_date">Date:</label>

            <input
                type="date"
                name="appointment_date"
                id="appointment_date"
                required>
        </div>

        {{-- Appointment start time --}}
        <div>
            <label for="appointment_start_time">Start Time:</label>

            <input
                type="time"
                name="appointment_start_time"
                id="appointment_start_time"
                required>
        </div>

        {{-- Appointment end time --}}
        <div>
            <label for="appointment_end_time">End Time:</label>

            <input
                type="time"
                name="appointment_end_time"
                id="appointment_end_time"
                required>
        </div>

        {{-- Reason for the appointment --}}
        <div>
            <label for="reason">Reason:</label>

            <input
                type="text"
                name="reason"
                id="reason"
                required>
        </div>

        {{-- Type of visit --}}
        <div>
            <label for="visit_type">Visit Type:</label>

            <select name="visit_type" id="visit_type" required>
                <option value="">Select visit type</option>
                <option value="InPerson">In Person</option>
                <option value="Online">Online</option>
                <option value="Emergency">Emergency</option>
                <option value="FollowUp">Follow Up</option>
            </select>
        </div>

        {{-- Additional notes --}}
        <div>
            <label for="notes">Notes:</label>

            <textarea
                name="notes"
                id="notes"
                rows="4"></textarea>
        </div>

        {{-- Submit the appointment request --}}
        <button type="submit">
            Create Appointment
        </button>

    </form>

</body>

</html>