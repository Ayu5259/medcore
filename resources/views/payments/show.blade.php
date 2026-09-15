<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payment #{{ $payment->id }}</title>
</head>

<body>

    <h1>Payment #{{ $payment->id }}</h1>

    @if (session('success'))
    <p>
        {{ session('success') }}
    </p>
    @endif

    <h2>Payment Information</h2>

    <p>
        <strong>Payment ID:</strong>
        {{ $payment->id }}
    </p>

    <p>
        <strong>Amount:</strong>
        {{ $payment->amount }}
    </p>

    <p>
        <strong>Method:</strong>
        {{ $payment->method }}
    </p>

    <p>
        <strong>Status:</strong>
        {{ $payment->status }}
    </p>

    <p>
        <strong>Paid At:</strong>
        {{ $payment->paid_at?->format('Y-m-d H:i') ?? '-' }}
    </p>

    <p>
        <strong>Transaction Code:</strong>
        {{ $payment->transaction_code ?? '-' }}
    </p>

    <p>
        <strong>Payment Gateway:</strong>
        {{ $payment->payment_gateway ?? '-' }}
    </p>


    <h2>Patient</h2>

    <p>
        <strong>Name:</strong>
        {{ $payment->patient?->user?->first_name }}
        {{ $payment->patient?->user?->last_name }}
    </p>


    <h2>Appointment</h2>

    @if ($payment->appointment)

    <p>
        <strong>Appointment ID:</strong>
        {{ $payment->appointment->id }}
    </p>

    <p>
        <strong>Date:</strong>
        {{ $payment->appointment->appointment_date?->format('Y-m-d') }}
    </p>

    <p>
        <strong>Start Time:</strong>
        {{ $payment->appointment->appointment_start_time }}
    </p>

    <p>
        <strong>End Time:</strong>
        {{ $payment->appointment->appointment_end_time }}
    </p>

    <p>
        <strong>Doctor:</strong>
        {{ $payment->appointment->doctor?->user?->first_name }}
        {{ $payment->appointment->doctor?->user?->last_name }}
    </p>

    @else

    <p>
        Appointment information is not available.
    </p>

    @endif


    <br>

    <a href="{{ route('payments.index') }}">
        Back to Payments
    </a>

</body>

</html>