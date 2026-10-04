@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Payment History</h2>
            <p class="text-muted mb-0">
                Payment history for your appointments
            </p>
        </div>

        <a href="{{ route('payments.index') }}" class="btn btn-outline-primary">
            Payments
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($payments->isEmpty())
    <div class="alert alert-info">
        No payment history found.
    </div>
    @else
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Appointment</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Paid At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($payments as $payment)
                        <tr>

                            <td>
                                {{ $payment->id }}
                            </td>

                            <td>
                                {{ $payment->patient?->user?->name ?? 'Unknown' }}
                            </td>

                            <td>
                                @if($payment->appointment)
                                {{ $payment->appointment->appointment_date }}
                                @else
                                N/A
                                @endif
                            </td>

                            <td>
                                {{ number_format($payment->amount, 2) }}
                            </td>

                            <td>
                                {{ ucfirst($payment->method) }}
                            </td>

                            <td>
                                @if($payment->status === 'paid')
                                <span class="badge bg-success">
                                    Paid
                                </span>
                                @elseif($payment->status === 'pending')
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>
                                @elseif($payment->status === 'failed')
                                <span class="badge bg-danger">
                                    Failed
                                </span>
                                @elseif($payment->status === 'refunded')
                                <span class="badge bg-secondary">
                                    Refunded
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($payment->status) }}
                                </span>
                                @endif
                            </td>

                            <td>
                                {{ $payment->paid_at?->format('Y-m-d H:i') ?? '—' }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('payments.show', $payment) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
    @endif


</div>
@endsection