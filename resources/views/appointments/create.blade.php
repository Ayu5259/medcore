@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- Page Header --}}
    <div class="mb-4">
        <h2 class="mb-1">Create Appointment</h2>
        <p class="text-muted mb-0">
            Book an appointment with a doctor.
        </p>
    </div>


    {{-- Validation Errors --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>

        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="card shadow-sm">
        <div class="card-body">

            <form
                method="POST"
                action="{{ route('appointments.store') }}">

                @csrf


                {{-- ===================================================== --}}
                {{-- PATIENT FORM --}}
                {{-- ===================================================== --}}

                @if(auth()->user()->patient)

                <div class="mb-3">
                    <label for="doctor_id" class="form-label">
                        Doctor
                    </label>

                    <select
                        name="doctor_id"
                        id="doctor_id"
                        class="form-select @error('doctor_id') is-invalid @enderror"
                        required>
                        <option value="">
                            Select a doctor
                        </option>

                        @foreach($doctors as $doctor)

                        <option
                            value="{{ $doctor->id }}"
                            {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            Dr.
                            {{ $doctor->user->first_name }}
                            {{ $doctor->user->last_name }}

                            @if($doctor->specialty)
                            - {{ $doctor->specialty->name }}
                            @endif
                        </option>

                        @endforeach

                    </select>

                    @error('doctor_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                @endif


                {{-- ===================================================== --}}
                {{-- DOCTOR FORM --}}
                {{-- ===================================================== --}}

                @if(auth()->user()->doctor)

                <div class="mb-3">

                    <label for="patient_id" class="form-label">
                        Patient
                    </label>

                    <select
                        name="patient_id"
                        id="patient_id"
                        class="form-select @error('patient_id') is-invalid @enderror"
                        required>

                        <option value="">
                            Select a patient
                        </option>

                        @foreach($patients as $patient)

                        <option
                            value="{{ $patient->id }}"
                            {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->user->first_name }}
                            {{ $patient->user->last_name }}
                        </option>

                        @endforeach

                    </select>

                    @error('patient_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- Doctor's Weekly Schedule --}}
                <div class="mb-4">

                    <label class="form-label">
                        Your Weekly Schedule
                    </label>

                    @if($schedules->isEmpty())

                    <div class="alert alert-warning">
                        You do not have any schedule defined yet.
                    </div>

                    @else

                    <div class="list-group">

                        @foreach($schedules as $schedule)

                        <div
                            class="list-group-item d-flex justify-content-between align-items-center">

                            <div>
                                <strong>
                                    {{ $schedule->day_of_week }}
                                </strong>
                            </div>

                            <div>
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </div>

                        </div>

                        @endforeach

                    </div>

                    @endif

                </div>

                @endif


                {{-- ===================================================== --}}
                {{-- DATE --}}
                {{-- ===================================================== --}}

                <div class="mb-3">

                    <label for="appointment_date" class="form-label">
                        Appointment Date
                    </label>

                    <input
                        type="date"
                        name="appointment_date"
                        id="appointment_date"
                        value="{{ old('appointment_date') }}"
                        class="form-control @error('appointment_date') is-invalid @enderror"
                        required>

                    @error('appointment_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- START TIME --}}
                {{-- ===================================================== --}}

                <div class="mb-3">

                    <label for="appointment_start_time" class="form-label">
                        Start Time
                    </label>

                    <input
                        type="time"
                        name="appointment_start_time"
                        id="appointment_start_time"
                        value="{{ old('appointment_start_time') }}"
                        class="form-control @error('appointment_start_time') is-invalid @enderror"
                        required>

                    @error('appointment_start_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- END TIME --}}
                {{-- ===================================================== --}}

                <div class="mb-3">

                    <label for="appointment_end_time" class="form-label">
                        End Time
                    </label>

                    <input
                        type="time"
                        name="appointment_end_time"
                        id="appointment_end_time"
                        value="{{ old('appointment_end_time') }}"
                        class="form-control @error('appointment_end_time') is-invalid @enderror"
                        required>

                    @error('appointment_end_time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- REASON --}}
                {{-- ===================================================== --}}

                <div class="mb-3">

                    <label for="reason" class="form-label">
                        Reason
                    </label>

                    <input
                        type="text"
                        name="reason"
                        id="reason"
                        value="{{ old('reason') }}"
                        class="form-control @error('reason') is-invalid @enderror"
                        placeholder="Reason for appointment"
                        required>

                    @error('reason')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- VISIT TYPE --}}
                {{-- ===================================================== --}}

                <div class="mb-3">

                    <label for="visit_type" class="form-label">
                        Visit Type
                    </label>

                    <select
                        name="visit_type"
                        id="visit_type"
                        class="form-select @error('visit_type') is-invalid @enderror"
                        required>

                        <option value="">
                            Select visit type
                        </option>

                        <option
                            value="InPerson"
                            {{ old('visit_type') === 'InPerson' ? 'selected' : '' }}>
                            In Person
                        </option>

                        <option
                            value="Online"
                            {{ old('visit_type') === 'Online' ? 'selected' : '' }}>
                            Online
                        </option>

                        <option
                            value="Emergency"
                            {{ old('visit_type') === 'Emergency' ? 'selected' : '' }}>
                            Emergency
                        </option>

                        <option
                            value="FollowUp"
                            {{ old('visit_type') === 'FollowUp' ? 'selected' : '' }}>
                            Follow Up
                        </option>

                    </select>

                    @error('visit_type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- NOTES --}}
                {{-- ===================================================== --}}

                <div class="mb-4">

                    <label for="notes" class="form-label">
                        Notes
                    </label>

                    <textarea
                        name="notes"
                        id="notes"
                        rows="4"
                        class="form-control @error('notes') is-invalid @enderror"
                        placeholder="Additional notes (optional)">{{ old('notes') }}</textarea>

                    @error('notes')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- ===================================================== --}}
                {{-- ACTIONS --}}
                {{-- ===================================================== --}}

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Create Appointment
                    </button>

                    <a
                        href="{{ route('appointments.index') }}"
                        class="btn btn-outline-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection