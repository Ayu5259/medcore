@extends('layouts.app')

@section('title', 'Prescriptions')

@section('content')
<div class="container-fluid py-4">

    {{-- Page heading --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Prescriptions</h1>
            <p class="text-muted mb-0">
                View and manage patient prescriptions.
            </p>
        </div>

        @if(auth()->user()->role?->name === 'Doctor')
        <a href="{{ route('prescriptions.create') }}"
            class="btn btn-primary">
            + Create Prescription
        </a>
        @endif
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

    {{-- Prescriptions table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h2 class="h6 fw-bold mb-0">Prescription Records</h2>
        </div>

        <div class="card-body p-0">
            @if($prescriptions->isEmpty())
            <div class="text-center py-5 px-3">
                <h3 class="h5 mb-2">No prescriptions found</h3>
                <p class="text-muted mb-0">
                    Prescriptions will appear here once they have been created.
                </p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-3">Prescription</th>
                            <th class="py-3">Doctor</th>
                            <th class="py-3">Patient</th>
                            <th class="py-3">Appointment Date</th>
                            <th class="py-3">Medicines</th>
                            <th class="px-3 py-3 text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($prescriptions as $prescription)
                        <tr>
                            <td class="px-3 fw-semibold">
                                #{{ $prescription->id }}
                            </td>

                            <td>
                                {{ $prescription->appointment?->doctor?->user?->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $prescription->appointment?->patient?->user?->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $prescription->appointment?->appointment_date?->format('M d, Y') ?? 'N/A' }}
                            </td>

                            <td>
                                <span class="badge text-bg-primary">
                                    {{ $prescription->prescriptionItems->count() }}
                                    {{ $prescription->prescriptionItems->count() === 1 ? 'medicine' : 'medicines' }}
                                </span>
                            </td>

                            <td class="px-3 text-end">
                                <a href="{{ route('prescriptions.show', $prescription) }}"
                                    class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        @if($prescriptions->isNotEmpty())
        <div class="card-footer bg-white text-muted small">
            Total prescriptions: {{ $prescriptions->count() }}
        </div>
        @endif
    </div>

</div>
@endsection