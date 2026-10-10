@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h2 class="mb-1">Create Appointment</h2>
        <p class="text-muted mb-0">
            Book an appointment using the doctor's available time slots.
        </p>
    </div>

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

            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf

                {{-- Patient selects a doctor --}}
                @if(auth()->user()->patient)
                <div class="mb-3">
                    <label for="doctor_id" class="form-label">Doctor</label>

                    <select
                        name="doctor_id"
                        id="doctor_id"
                        class="form-select @error('doctor_id') is-invalid @enderror"
                        required>
                        <option value="">Select a doctor</option>

                        @foreach($doctors as $doctor)
                        <option
                            value="{{ $doctor->id }}"
                            @selected((string) old('doctor_id')===(string) $doctor->id)
                            >
                            Dr. {{ $doctor->user->first_name }}
                            {{ $doctor->user->last_name }}
                            @if($doctor->specialty)
                            - {{ $doctor->specialty->name }}
                            @endif
                        </option>
                        @endforeach
                    </select>

                    @error('doctor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @endif

                {{-- Doctor selects a patient --}}
                @if(auth()->user()->doctor)
                <div class="mb-3">
                    <label for="patient_id" class="form-label">Patient</label>

                    <select
                        name="patient_id"
                        id="patient_id"
                        class="form-select @error('patient_id') is-invalid @enderror"
                        required>
                        <option value="">Select a patient</option>

                        @foreach($patients as $patient)
                        <option
                            value="{{ $patient->id }}"
                            @selected((string) old('patient_id')===(string) $patient->id)
                            >
                            {{ $patient->user->first_name }}
                            {{ $patient->user->last_name }}
                        </option>
                        @endforeach
                    </select>

                    @error('patient_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Your Weekly Schedule</label>

                    @if($schedules->isEmpty())
                    <div class="alert alert-warning mb-0">
                        You do not have any schedule defined yet.
                        Add your working hours before booking appointments.
                    </div>
                    @else
                    <div class="list-group">
                        @foreach($schedules as $schedule)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <strong>{{ $schedule->day_of_week }}</strong>
                            <span>
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

                {{-- Appointment date --}}
                <div class="mb-3">
                    <label for="appointment_date" class="form-label">
                        Appointment Date
                    </label>

                    <input
                        type="date"
                        name="appointment_date"
                        id="appointment_date"
                        value="{{ old('appointment_date') }}"
                        min="{{ now()->toDateString() }}"
                        class="form-control @error('appointment_date') is-invalid @enderror"
                        required>

                    @error('appointment_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Available slots --}}
                <div class="mb-3">
                    <label for="appointment_start_time" class="form-label">
                        Available Time Slots
                    </label>

                    <select
                        name="appointment_start_time"
                        id="appointment_start_time"
                        class="form-select @error('appointment_start_time') is-invalid @enderror"
                        data-old-start="{{ old('appointment_start_time') }}"
                        required
                        disabled>
                        <option value="">Select a date first</option>
                    </select>

                    @error('appointment_start_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div id="slots-message" class="form-text" aria-live="polite">
                        Select a doctor and date to see available times.
                    </div>

                    <div id="slots-error" class="alert alert-danger mt-2 d-none" role="alert"></div>
                </div>

                {{-- The selected slot determines the end time --}}
                <input
                    type="hidden"
                    name="appointment_end_time"
                    id="appointment_end_time"
                    value="{{ old('appointment_end_time') }}">

                {{-- Reason --}}
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>

                    <input
                        type="text"
                        name="reason"
                        id="reason"
                        value="{{ old('reason') }}"
                        class="form-control @error('reason') is-invalid @enderror"
                        placeholder="Reason for appointment"
                        maxlength="255"
                        required>

                    @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Visit type --}}
                <div class="mb-3">
                    <label for="visit_type" class="form-label">Visit Type</label>

                    <select
                        name="visit_type"
                        id="visit_type"
                        class="form-select @error('visit_type') is-invalid @enderror"
                        required>
                        <option value="">Select visit type</option>
                        <option value="InPerson" @selected(old('visit_type')==='InPerson' )>In Person</option>
                        <option value="Online" @selected(old('visit_type')==='Online' )>Online</option>
                        <option value="Emergency" @selected(old('visit_type')==='Emergency' )>Emergency</option>
                        <option value="FollowUp" @selected(old('visit_type')==='FollowUp' )>Follow Up</option>
                    </select>

                    @error('visit_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Notes --}}
                <div class="mb-4">
                    <label for="notes" class="form-label">Notes</label>

                    <textarea
                        name="notes"
                        id="notes"
                        rows="4"
                        class="form-control @error('notes') is-invalid @enderror"
                        placeholder="Additional notes (optional)">{{ old('notes') }}</textarea>

                    @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Create Appointment
                    </button>

                    <a href="{{ route('appointments.index') }}" class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('appointment_date');
        const doctorSelect = document.getElementById('doctor_id');
        const startSelect = document.getElementById('appointment_start_time');
        const endInput = document.getElementById('appointment_end_time');
        const message = document.getElementById('slots-message');
        const errorBox = document.getElementById('slots-error');

        const slotsUrl = "{{ route('appointments.available-slots') }}";
        const oldStart = startSelect.dataset.oldStart;
        let requestNumber = 0;

        function resetSlots(text) {
            startSelect.replaceChildren(new Option(text, ''));
            startSelect.disabled = true;
            endInput.value = '';
        }

        async function loadSlots() {
            const currentRequest = ++requestNumber;
            const date = dateInput.value;
            const doctorId = doctorSelect ? doctorSelect.value : '';

            errorBox.textContent = '';
            errorBox.classList.add('d-none');
            endInput.value = '';

            if (!date) {
                resetSlots('Select a date first');
                message.textContent = 'Choose a date to see available times.';
                return;
            }

            if (doctorSelect && !doctorId) {
                resetSlots('Select a doctor first');
                message.textContent = 'Choose a doctor before selecting a time.';
                return;
            }

            resetSlots('Loading available times...');
            message.textContent = 'Checking the doctor'


            const params = new URLSearchParams({
                date
            });

            if (doctorId) {
                params.set('doctor_id', doctorId);
            }

            try {
                const response = await fetch(`${slotsUrl}?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                const data = await response.json();

                // Ignore stale responses if the user changed the date or doctor.
                if (currentRequest !== requestNumber) {
                    return;
                }

                if (!response.ok) {
                    throw new Error(data.message || 'Could not load available times.');
                }

                resetSlots('Select a time');

                if (!Array.isArray(data.slots) || data.slots.length === 0) {
                    resetSlots('No available times');
                    message.textContent = 'No available slots for this date. Try another date.';
                    return;
                }

                data.slots.forEach(function(slot) {
                    const option = new Option(
                        `${slot.start} – ${slot.end}`,
                        slot.start
                    );

                    option.dataset.end = slot.end;
                    startSelect.add(option);
                });

                startSelect.disabled = false;
                message.textContent = `${data.slots.length} available slot(s).`;

                if (oldStart) {
                    const oldOption = Array.from(startSelect.options)
                        .find(option => option.value === oldStart);

                    if (oldOption) {
                        startSelect.value = oldStart;
                        endInput.value = oldOption.dataset.end || '';
                    }
                }
            } catch (error) {
                if (currentRequest !== requestNumber) {
                    return;
                }

                resetSlots('Unable to load times');
                message.textContent = 'Available times could not be loaded.';
                errorBox.textContent = error.message;
                errorBox.classList.remove('d-none');
            }
        }

        startSelect.addEventListener('change', function() {
            const option = startSelect.selectedOptions[0];
            endInput.value = option?.dataset?.end || '';
        });

        dateInput.addEventListener('change', loadSlots);

        if (doctorSelect) {
            doctorSelect.addEventListener('change', loadSlots);
        }

        if (dateInput.value) {
            loadSlots();
        }
    });
</script>
@endpush