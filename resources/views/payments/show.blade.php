@extends('layouts.app')

@section('title', 'Payment Details | MediCore')

@section('content')
@php
$status = strtolower($payment->status ?? 'unknown');

$statusClasses = [
'paid' => 'text-bg-success',
'pending' => 'text-bg-warning',
'failed' => 'text-bg-danger',
'refunded' => 'text-bg-secondary',
];

$statusClass = $statusClasses[$status] ?? 'text-bg-light border text-dark';

$patientName = trim(
($payment->patient?->user?->first_name ?? '') . ' ' .
($payment->patient?->user?->last_name ?? '')
);

$doctorName = trim(
($payment->appointment?->doctor?->user?->first_name ?? '') . ' ' .
($payment->appointment?->doctor?->user?->last_name ?? '')
);
@endphp

<div class="container-fluid px-0">

    {{-- Page heading --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <a href="{{ route('payments.index') }}"
                    class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Payments
                </a>
            </div>

            <h2 class="fw-bold mb-1">Payment Details</h2>
            <p class="text-muted mb-0">
                Review payment information and the associated appointment.
            </p>
        </div>

        <div class="text-md-end">
            <div class="text-muted small mb-1">Payment Reference</div>
            <span class="fs-5 fw-bold">#{{ $payment->id }}</span>
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">

        {{-- Main payment information --}}
        <div class="col-12 col-xl-8">

            {{-- Payment summary --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="row align-items-center g-3">

                        <div class="col-12 col-md">
                            <div class="text-muted small mb-2">Payment Amount</div>
                            <h1 class="fw-bold mb-2">
                                {{number_format((float) $payment->amount, 2) }}$
                            </h1>
                            <span class="badge rounded-pill {{ $statusClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </div>

                        <div class="col-auto">
                            <div class="rounded-4 bg-primary-subtle text-primary p-4">
                                <i class="bi bi-credit-card fs-1"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Payment information --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-receipt me-2 text-primary"></i>
                        Payment Information
                    </h5>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Payment ID</div>
                            <div class="fw-semibold">#{{ $payment->id }}</div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Payment Method</div>
                            <div class="fw-semibold">
                                {{ ucfirst($payment->method ?? 'N/A') }}
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Transaction Code</div>
                            <div class="fw-semibold text-break">
                                {{ $payment->transaction_code ?? 'Not available' }}
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Payment Gateway</div>
                            <div class="fw-semibold">
                                {{ $payment->payment_gateway ?? 'Not specified' }}
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Paid At</div>
                            <div class="fw-semibold">
                                {{ $payment->paid_at?->format('Y-m-d H:i') ?? 'Not paid yet' }}
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Record Created</div>
                            <div class="fw-semibold">
                                {{ $payment->created_at?->format('Y-m-d H:i') ?? '—' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Appointment information --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 px-4 pt-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-calendar-check me-2 text-primary"></i>
                        Appointment Information
                    </h5>
                </div>

                <div class="card-body p-4">
                    @if($payment->appointment)

                    <div class="row g-4">

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Appointment ID</div>
                            <div class="fw-semibold">
                                #{{ $payment->appointment->id }}
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Appointment Date</div>
                            <div class="fw-semibold">
                                {{ $payment->appointment->appointment_date?->format('Y-m-d') ?? '—' }}
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">Start Time</div>
                            <div class="fw-semibold">
                                {{ $payment->appointment->appointment_start_time ?? '—' }}
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="text-muted small mb-1">End Time</div>
                            <div class="fw-semibold">
                                {{ $payment->appointment->appointment_end_time ?? '—' }}
                            </div>
                        </div>

                    </div>

                    @else

                    <div class="alert alert-light border mb-0">
                        Appointment information is not available.
                    </div>

                    @endif
                </div>
            </div>

        </div>

        {{-- Patient and doctor sidebar --}}
        <div class="col-12 col-xl-4">

            {{-- Patient card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 52px; height: 52px;">
                            <i class="bi bi-person fs-3"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Patient</h5>
                            <p class="text-muted small mb-0">Associated with this payment</p>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <div class="text-muted small mb-1">Patient Name</div>
                        <div class="fw-semibold">
                            {{ trim(
            ($payment->patient?->user?->first_name ?? '') . ' ' .
            ($payment->patient?->user?->last_name ?? '')
        ) ?: 'Unknown patient'  }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- Doctor card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center flex-shrink-0"
                            style="width: 52px; height: 52px;">
                            <i class="bi bi-person-badge fs-3"></i>
                        </div>

                        <div>
                            <h5 class="fw-bold mb-1">Doctor</h5>
                            <p class="text-muted small mb-0">Appointment provider</p>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <div class="text-muted small mb-1">Doctor Name</div>
                        <div class="fw-semibold">
                            {{ $doctorName !== '' ? $doctorName : 'Unknown doctor' }}
                        </div>
                    </div>

                </div>
            </div>

            {{-- Status explanation --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Payment Status
                    </h6>

                    @switch($status)
                    @case('paid')
                    <p class="text-muted small mb-0">
                        This payment is marked as successful.
                    </p>
                    @break

                    @case('pending')
                    <p class="text-muted small mb-0">
                        This payment is awaiting confirmation. A pending status does not mean the transaction has succeeded.
                    </p>
                    @break

                    @case('failed')
                    <p class="text-muted small mb-0">
                        This payment is marked as failed.
                    </p>
                    @break

                    @case('refunded')
                    <p class="text-muted small mb-0">
                        This payment is marked as refunded.
                    </p>
                    @break

                    @default
                    <p class="text-muted small mb-0">
                        No additional information is available for this status.
                    </p>
                    @endswitch
                </div>
            </div>

        </div>
    </div>

</div>
@endsection