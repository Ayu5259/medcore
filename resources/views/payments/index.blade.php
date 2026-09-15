<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Payments</title>
</head>

<body>

    <h1>Payments</h1>

    @if (session('success'))
    <p>
        {{ session('success') }}
    </p>
    @endif

    @if ($payments->isEmpty())
    <p>No payments found.</p>
    @else

    <table border="1" cellpadding="8" cellspacing="0">

        <thead>
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Appointment Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Paid At</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($payments as $payment)

            <tr>

                <td>
                    {{ $payment->id }}
                </td>

                <td>
                    {{ $payment->patient?->user?->first_name }}
                    {{ $payment->patient?->user?->last_name }}
                </td>

                <td>
                    {{ $payment->appointment?->doctor?->user?->first_name }}
                    {{ $payment->appointment?->doctor?->user?->last_name }}
                </td>

                <td>
                    {{ $payment->appointment?->appointment_date?->format('Y-m-d') }}
                </td>

                <td>
                    {{ $payment->amount }}
                </td>

                <td>
                    {{ $payment->method }}
                </td>

                <td>
                    {{ $payment->status }}
                </td>

                <td>
                    {{ $payment->paid_at?->format('Y-m-d H:i') ?? '-' }}
                </td>

                <td>
                    <a href="{{ route('payments.show', $payment) }}">
                        View
                    </a>
                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    @endif

    <br>

    @if (auth()->user()->role?->name === 'Patient' || strtolower(auth()->user()->role?->name ?? '') === 'patient')
    <a href="{{ route('payments.create') }}">
        Create Payment
    </a>
    @endif

</body>

</html>