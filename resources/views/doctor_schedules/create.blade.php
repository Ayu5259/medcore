@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Add Schedule</h2>
            <p class="text-muted mb-0">
                Define your weekly working hours.
            </p>
        </div>

        <a href="{{ route('doctor-schedules.index') }}" class="btn btn-secondary">
            Back to Schedule
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('doctor-schedules.store') }}">
                @csrf

                {{-- Day --}}
                <div class="mb-3">
                    <label for="day_of_week" class="form-label">
                        Day of Week
                    </label>

                    <select
                        name="day_of_week"
                        id="day_of_week"
                        class="form-select @error('day_of_week') is-invalid @enderror"
                        required>
                        <option value="">Select a day</option>

                        @foreach($daysOfWeek as $day)
                        <option
                            value="{{ $day }}"
                            {{ old('day_of_week') === $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                        @endforeach
                    </select>

                    @error('day_of_week')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- Start Time --}}
                <div class="mb-3">
                    <label for="start_time" class="form-label">
                        Start Time
                    </label>

                    <input
                        type="time"
                        name="start_time"
                        id="start_time"
                        value="{{ old('start_time') }}"
                        class="form-control @error('start_time') is-invalid @enderror"
                        required>

                    @error('start_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{-- End Time --}}
                <div class="mb-3">
                    <label for="end_time" class="form-label">
                        End Time
                    </label>

                    <input
                        type="time"
                        name="end_time"
                        id="end_time"
                        value="{{ old('end_time') }}"
                        class="form-control @error('end_time') is-invalid @enderror"
                        required>

                    @error('end_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Add Schedule
                    </button>

                    <a
                        href="{{ route('doctor-schedules.index') }}"
                        class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection