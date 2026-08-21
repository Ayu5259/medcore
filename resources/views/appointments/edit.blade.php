<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
</head>

<body>

    <h1>Edit Appointment</h1>

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

    @if (session('success'))
    <div>
        {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('appointments.update', $appointment) }}">
        @csrf
        @method('PATCH')

        <div>
            <label for="appointment_date">Appointment Date</label>

            <input
                type="date"
                id="appointment_date"
                name="appointment_date"
                value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}"
                required>
        </div>

        <div>
            <label for="appointment_start_time">Start Time</label>

            <input
                type="time"
                id="appointment_start_time"
                name="appointment_start_time"
                value="{{ old('appointment_start_time', substr($appointment->appointment_start_time, 0, 5)) }}"
                required>
        </div>

        <div>
            <label for="appointment_end_time">End Time</label>

            <input
                type="time"
                id="appointment_end_time"
                name="appointment_end_time"
                value="{{ old('appointment_end_time', substr($appointment->appointment_end_time, 0, 5)) }}"
                required>
        </div>

        <div>
            <label for="room_number">Room Number</label>

            <input
                type="number"
                id="room_number"
                name="room_number"
                value="{{ old('room_number', $appointment->room_number) }}"
                min="1"
                required>
        </div>

        <div>
            <label for="visit_type">Visit Type</label>

            <select id="visit_type" name="visit_type" required>
                <option value="InPerson"
                    {{ old('visit_type', $appointment->visit_type) === 'InPerson' ? 'selected' : '' }}>
                    In Person
                </option>

                <option value="Online"
                    {{ old('visit_type', $appointment->visit_type) === 'Online' ? 'selected' : '' }}>
                    Online
                </option>

                <option value="Emergency"
                    {{ old('visit_type', $appointment->visit_type) === 'Emergency' ? 'selected' : '' }}>
                    Emergency
                </option>

                <option value="FollowUp"
                    {{ old('visit_type', $appointment->visit_type) === 'FollowUp' ? 'selected' : '' }}>
                    Follow Up
                </option>
            </select>
        </div>

        <div>
            <label for="notes">Notes</label>

            <textarea
                id="notes"
                name="notes"
                rows="5">{{ old('notes', $appointment->notes) }}</textarea>
        </div>

        <button type="submit">
            Update Appointment
        </button>
    </form>

    <a href="{{ route('appointments.show', $appointment) }}">
        Cancel
    </a>

</body>

</html>