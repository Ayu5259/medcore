@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Doctor Schedule</h2>

            <p class="text-muted mb-0">
                Weekly working schedule and appointments
            </p>
        </div>

        @if(auth()->user()->doctor)
        <a
            href="{{ route('doctor-schedules.create') }}"
            class="btn btn-primary">
            + Add Schedule
        </a>
        @endif

    </div>


    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    {{-- Weekly Schedule --}}
    <div class="mb-5">

        <h4 class="mb-3">
            Weekly Schedule
        </h4>

        @if($schedules->isEmpty())

        <div class="alert alert-info">
            No schedule has been defined yet.
        </div>

        @else

        @php
        $currentDay = null;
        @endphp

        @foreach($schedules as $schedule)

        @if($currentDay !== $schedule->day_of_week)

        @php
        $currentDay = $schedule->day_of_week;
        @endphp

        @if(!$loop->first)
    </div>
</div>
@endif

<div class="card shadow-sm mb-3">

    <div class="card-header d-flex justify-content-between align-items-center">

        <strong>
            {{ $schedule->day_of_week }}
        </strong>

    </div>

    <div class="card-body">

        @endif

        <div class="d-flex justify-content-between align-items-center border-bottom py-2">

            <div>
                <strong>
                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                </strong>
            </div>

            @if($schedule->doctor?->user)

            <div class="text-muted">
                Dr.
                {{ $schedule->doctor->user->first_name }}
                {{ $schedule->doctor->user->last_name }}
            </div>

            @endif


            {{-- Doctor Controls --}}
            @if(auth()->user()->doctor)

            <div class="d-flex gap-2">

                <a
                    href="{{ route('doctor-schedules.edit', $schedule) }}"
                    class="btn btn-sm btn-outline-primary">
                    Edit
                </a>

                <form
                    method="POST"
                    action="{{ route('doctor-schedules.destroy', $schedule) }}"
                    onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-sm btn-outline-danger">
                        Delete
                    </button>
                </form>

            </div>

            @endif

        </div>


        @if($loop->last)

    </div>
</div>

@endif

@endforeach

@endif

</div>


{{-- Appointments --}}
<div>

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h4 class="mb-1">
                Appointments
            </h4>

            <p class="text-muted mb-0">
                Reserved appointments
            </p>
        </div>

    </div>


    @if($appointments->isEmpty())

    <div class="alert alert-info">
        No appointments found.
    </div>

    @else

    <div class="card shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Date</th>

                        <th>Time</th>

                        @if(auth()->user()->doctor)
                        <th>Patient</th>
                        @else
                        <th>Doctor</th>
                        @endif

                        <th>Visit Type</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($appointments as $appointment)

                    <tr>

                        {{-- Date --}}
                        <td>
                            {{ $appointment->appointment_date->format('Y-m-d') }}
                        </td>


                        {{-- Time --}}
                        <td>
                            {{ \Carbon\Carbon::parse($appointment->appointment_start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('H:i') }}
                        </td>


                        {{-- Patient --}}
                        @if(auth()->user()->doctor)

                        <td>

                            @if($appointment->patient?->user)

                            <strong>
                                {{ $appointment->patient->user->first_name }}
                                {{ $appointment->patient->user->last_name }}
                            </strong>

                            @else

                            <span class="text-muted">
                                Unknown patient
                            </span>

                            @endif

                        </td>

                        @else

                        {{-- Doctor --}}
                        <td>

                            @if($appointment->doctor?->user)

                            <strong>
                                Dr.
                                {{ $appointment->doctor->user->first_name }}
                                {{ $appointment->doctor->user->last_name }}
                            </strong>

                            @else

                            <span class="text-muted">
                                Unknown doctor
                            </span>

                            @endif

                        </td>

                        @endif


                        {{-- Visit Type --}}
                        <td>
                            {{ $appointment->visit_type }}
                        </td>


                        {{-- Status --}}
                        <td>

                            @if($appointment->status === 'confirmed')

                            <span class="badge bg-success">
                                Confirmed
                            </span>

                            @elseif($appointment->status === 'pending')

                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>

                            @elseif($appointment->status === 'cancelled')

                            <span class="badge bg-danger">
                                Cancelled
                            </span>

                            @elseif($appointment->status === 'completed')

                            <span class="badge bg-primary">
                                Completed
                            </span>

                            @else

                            <span class="badge bg-secondary">
                                {{ $appointment->status }}
                            </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    @endif

</div>

</div>
@endsection