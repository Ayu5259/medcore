<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Payment</title>
</head>

<body>

    <h1>Create Payment</h1>

    @if ($errors->any())
    <div>
        <h3>Please fix the following errors:</h3>

        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if ($appointments->isEmpty())

    <p>
        You have no appointments available for payment.
    </p>

    <a href="{{ route('payments.index') }}">
        Back to Payments
    </a>

    @else

    <form method="POST" action="{{ route('payments.store') }}">

        @csrf

        <div>

            <label for="appointment_id">
                Select Appointment
            </label>

            <select name="appointment_id" id="appointment_id" required>

                <option value="">
                    -- Select an appointment --
                </option>

                @foreach ($appointments as $appointment)

                <option
                    value="{{ $appointment->id }}"
                    {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>

                    Appointment #{{ $appointment->id }}
                    -
                    Dr.
                    {{ $appointment->doctor?->user?->first_name }}
                    {{ $appointment->doctor?->user?->last_name }}
                    -
                    {{ $appointment->appointment_date?->format('Y-m-d') }}
                    -
                    {{ $appointment->appointment_start_time }}

                </option>

                @endforeach

            </select>

        </div>

        <br>

        <p>
            Payment method: Card
        </p>

        <p>
            The payment amount will be calculated from the doctor's consultation fee.
        </p>

        <button type="submit">
            Create Payment
        </button>

    </form>

    <br>

    <a href="{{ route('payments.index') }}">
        Back to Payments
    </a>

    @endif

</body>

</html>