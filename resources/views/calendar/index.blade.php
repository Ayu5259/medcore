@extends('layouts.app')

@section('title', 'Appointment Calendar')

@section('content')
<div class="container-fluid py-4">

    @php
    $days = collect();

    for ($date = $weekStart->copy(); $date->lte($weekEnd); $date->addDay()) {
    $days->push($date->copy());
    }

    $isDoctor = auth()->user()->doctor !== null;
    @endphp

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h2 class="mb-1">Appointment Calendar</h2>
            <p class="text-muted mb-0">
                Weekly overview of your appointments.
            </p>
        </div>

        <a href="{{ route('doctor-schedules.index') }}"
            class="btn btn-outline-secondary">
            Weekly Schedules
        </a>
    </div>

    {{-- Week Navigation --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-3">

            <a href="{{ route('calendar.index', ['week' => $previousWeek->toDateString()]) }}"
                class="btn btn-outline-primary">
                &larr; Previous Week
            </a>

            <div class="text-center">
                <div class="fw-semibold">
                    {{ $weekStart->format('M d, Y') }}
                    –
                    {{ $weekEnd->format('M d, Y') }}
                </div>
                <small class="text-muted">
                    {{ $appointments->count() }} appointments
                </small>
            </div>

            <a href="{{ route('calendar.index', ['week' => $nextWeek->toDateString()]) }}"
                class="btn btn-outline-primary">
                Next Week &rarr;
            </a>
        </div>
    </div>

    {{-- Calendar Grid --}}
    <style>
        .calendar-scroll {
            overflow-x: auto;
            padding-bottom: 8px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, minmax(190px, 1fr));
            gap: 12px;
            min-width: 1400px;
        }

        .calendar-day {
            min-height: 300px;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 10px;
            overflow: hidden;
        }

        .calendar-day-header {
            padding: 12px;
            background: var(--bs-tertiary-bg);
            border-bottom: 1px solid var(--bs-border-color);
        }

        .calendar-appointment {
            padding: 12px;
            margin: 10px;
            border: 1px solid var(--bs-border-color);
            border-left: 4px solid var(--bs-primary);
            border-radius: 7px;
            overflow-wrap: anywhere;
        }

        .calendar-empty {
            padding: 20px 10px;
            text-align: center;
            color: var(--bs-secondary-color);
            font-size: 0.875rem;
        }
    </style>

    <div class="calendar-scroll">
        <div class="calendar-grid">

            @foreach($days as $day)

            @php
            $dayAppointments = $appointments->filter(function ($appointment) use ($day) {
            return \Carbon\Carbon::parse($appointment->appointment_date)
            ->isSameDay($day);
            });
            @endphp

            <section class="calendar-day">

                <div class="calendar-day-header">
                    <div class="text-muted small">
                        {{ $day->format('l') }}
                    </div>

                    <div class="fs-5 fw-bold">
                        {{ $day->format('d') }}
                    </div>

                    <div class="small text-muted">
                        {{ $day->format('M Y') }}
                    </div>

                    <span class="badge bg-secondary mt-2">
                        {{ $dayAppointments->count() }}
                        {{ $dayAppointments->count() === 1 ? 'appointment' : 'appointments' }}
                    </span>
                </div>

                @forelse($dayAppointments as $appointment)

                @php
                $statusClass = match($appointment->status) {
                'confirmed' => 'success',
                'pending' => 'warning',
                'cancelled' => 'danger',
                'completed' => 'primary',
                default => 'secondary',
                };
                @endphp

                <article class="calendar-appointment">

                    <div class="fw-bold mb-2">
                        {{ \Carbon\Carbon::parse($appointment->appointment_start_time)->format('H:i') }}
                        –
                        {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('H:i') }}
                    </div>

                    <div class="small mb-2">
                        @if($isDoctor)
                        @if($appointment->patient?->user)
                        {{ $appointment->patient->user->first_name }}
                        {{ $appointment->patient->user->last_name }}
                        @else
                        Unknown Patient
                        @endif
                        @else
                        @if($appointment->doctor?->user)
                        Dr. {{ $appointment->doctor->user->first_name }}
                        {{ $appointment->doctor->user->last_name }}
                        @else
                        Unknown Doctor
                        @endif
                        @endif
                    </div>

                    <div class="small text-muted mb-2">
                        {{ $appointment->visit_type ?? 'General visit' }}
                    </div>

                    <span class="badge bg-{{ $statusClass }}">
                        {{ ucfirst($appointment->status ?? 'unknown') }}
                    </span>

                    <div class="mt-3">
                        <a href="{{ route('appointments.show', $appointment) }}"
                            class="btn btn-sm btn-outline-primary w-100">
                            View Details
                        </a>
                    </div>

                </article>

                @empty

                <div class="calendar-empty">
                    No appointments
                </div>

                @endforelse

            </section>

            @endforeach

        </div>
    </div>

</div>
@endsection