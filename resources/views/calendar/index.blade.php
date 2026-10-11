@extends('layouts.app')

@section('title', 'Appointment Calendar')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Appointment Calendar</h2>
            <p class="text-muted mb-0">
                View your appointments for the selected week.
            </p>
        </div>

        <a href="{{ route('doctor-schedules.index') }}"
            class="btn btn-outline-secondary">
            Weekly Schedules
        </a>
    </div>

    {{-- Week navigation --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">

            <a href="{{ route('calendar.index', ['week' => $previousWeek->toDateString()]) }}"
                class="btn btn-outline-primary">
                &larr; Previous Week
            </a>

            <div class="text-center">
                <strong>
                    {{ $weekStart->format('M d, Y') }}
                    –
                    {{ $weekEnd->format('M d, Y') }}
                </strong>
            </div>

            <a href="{{ route('calendar.index', ['week' => $nextWeek->toDateString()]) }}"
                class="btn btn-outline-primary">
                Next Week &rarr;
            </a>

        </div>
    </div>

    {{-- Appointments --}}
    @if($appointments->isEmpty())
    <div class="alert alert-info">
        No appointments found for this week.
    </div>
    @else
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>

                            @if(auth()->user()->doctor)
                            <th>Patient</th>
                            @elseif(auth()->user()->patient)
                            <th>Doctor</th>
                            @endif

                            <th>Visit Type</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D, M d, Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_start_time)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('H:i') }}
                            </td>


                            @if(auth()->user()->doctor)
                            <td>
                                {{ $appointment->patient?->user?->first_name ?? '' }}
                                {{ $appointment->patient?->user?->last_name ?? '' }}

                                @if(!$appointment->patient?->user)
                                Unknown Patient
                                @endif
                            </td>
                            @elseif(auth()->user()->patient)
                            <td>
                                @if($appointment->doctor?->user)
                                Dr. {{ $appointment->doctor->user->first_name }}
                                {{ $appointment->doctor->user->last_name }}
                                @else
                                Unknown Doctor
                                @endif
                            </td>
                            @endif

                            <td>
                                {{ $appointment->visit_type ?? '—' }}
                            </td>

                            <td>
                                @php
                                $statusClass = match($appointment->status) {
                                'confirmed' => 'success',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                'completed' => 'primary',
                                default => 'secondary',
                                };
                                @endphp

                                <span class="badge bg-{{ $statusClass }}">
                                    {{ ucfirst($appointment->status ?? 'unknown') }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('appointments.show', $appointment) }}"
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