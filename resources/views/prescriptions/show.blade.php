@extends('layouts.app')

@section('title', 'Prescription Details')

@section('content')
<div class="container-fluid py-4">

    {{-- Page heading --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Prescription #{{ $prescription->id }}</h1>
            <p class="text-muted mb-0">Prescription details and medication instructions</p>
        </div>

        <a href="{{ route('prescriptions.index') }}" class="btn btn-outline-secondary">
            Back to Prescriptions
        </a>
    </div>

    {{-- Appointment information --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h2 class="h5 mb-0">Appointment Information</h2>
        </div>

        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="text-muted small">Appointment ID</div>
                    <div class="fw-semibold">
                        {{ $prescription->appointment?->id ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="text-muted small">Appointment Date</div>
                    <div class="fw-semibold">
                        {{ $prescription->appointment?->appointment_date?->format('Y-m-d') ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="text-muted small">Prescription ID</div>
                    <div class="fw-semibold">#{{ $prescription->id }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Doctor and patient --}}
    <div class="row g-4 mb-4">

        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Doctor</h2>

                    <div class="fw-semibold">
                        {{ $prescription->appointment?->doctor?->user?->first_name ?? '' }}
                        {{ $prescription->appointment?->doctor?->user?->last_name ?? '' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h2 class="h5 mb-3">Patient</h2>

                    <div class="fw-semibold">
                        {{ $prescription->appointment?->patient?->user?->first_name ?? '' }}
                        {{ $prescription->appointment?->patient?->user?->last_name ?? '' }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Medicine list --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h2 class="h5 mb-0">Prescribed Medicines</h2>
        </div>

        <div class="card-body">

            @forelse ($prescription->prescriptionItems as $item)

            <div class="border rounded p-3 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-3">
                    <h3 class="h5 mb-0">
                        {{ $item->medicine?->name ?? 'Medicine unavailable' }}
                    </h3>

                    <span class="badge text-bg-primary">
                        {{ $item->dosage ?? 'Dosage not specified' }}
                    </span>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Generic Name</div>
                        <div>{{ $item->medicine?->generic_name ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Manufacturer</div>
                        <div>{{ $item->medicine?->manufacturer ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Dosage Form</div>
                        <div>{{ $item->medicine?->dosage_form ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Frequency</div>
                        <div>{{ $item->frequency ?? 'N/A' }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Duration</div>
                        <div>{{ $item->duration ?? 'N/A' }}</div>
                    </div>

                    <div class="col-12">
                        <div class="text-muted small">Instructions</div>
                        <div>{{ $item->instructions ?? 'No additional instructions' }}</div>
                    </div>
                </div>
            </div>

            @empty
            <div class="alert alert-info mb-0">
                No medicines have been added to this prescription.
            </div>
            @endforelse

        </div>
    </div>

    {{-- Actions --}}
    <div class="d-flex flex-wrap gap-2">

        @can('update', $prescription)
        <a href="{{ route('prescriptions.edit', $prescription) }}"
            class="btn btn-primary">
            Edit Prescription
        </a>
        @endcan

        <a href="{{ route('prescriptions.index') }}"
            class="btn btn-outline-secondary">
            Back to Prescriptions
        </a>

    </div>

</div>
@endsection