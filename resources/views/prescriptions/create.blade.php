@extends('layouts.app')

@section('title', 'Create Prescription')

@section('content')
<div class="container-fluid py-4">

    {{-- Page heading --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Create Prescription</h1>
            <p class="text-muted mb-0">
                Select a patient appointment and prescribe medicines.
            </p>
        </div>

        <a href="{{ route('prescriptions.index') }}"
            class="btn btn-outline-secondary">
            Back to Prescriptions
        </a>
    </div>

    {{-- Validation errors --}}
    @if($errors->any())
    <div class="alert alert-danger">
        <div class="fw-semibold mb-2">
            Please correct the following errors:
        </div>

        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('prescriptions.store') }}">
        @csrf

        {{-- Appointment section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h2 class="h5 fw-bold mb-0">1. Appointment Information</h2>
            </div>

            <div class="card-body">
                <label for="appointment_id" class="form-label fw-semibold">
                    Patient Appointment <span class="text-danger">*</span>
                </label>

                <select name="appointment_id"
                    id="appointment_id"
                    class="form-select @error('appointment_id') is-invalid @enderror"
                    required>
                    <option value="">Select an appointment</option>

                    @foreach($appointments as $appointment)
                    <option value="{{ $appointment->id }}"
                        @selected((string) old('appointment_id')===(string) $appointment->id)>
                        Appointment #{{ $appointment->id }}
                        — {{ $appointment->patient?->user?->name ?? 'Unknown patient' }}
                        — {{ $appointment->appointment_date?->format('M d, Y') ?? 'No date' }}
                    </option>
                    @endforeach
                </select>

                @error('appointment_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                @if($appointments->isEmpty())
                <div class="form-text text-warning mt-2">
                    No eligible appointments are available.
                    Only your appointments without an existing prescription can be selected.
                </div>
                @else
                <div class="form-text mt-2">
                    Only appointments eligible for your account are listed.
                </div>
                @endif
            </div>
        </div>

        {{-- Medicines section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center gap-2">
                <h2 class="h5 fw-bold mb-0">2. Prescribed Medicines</h2>

                <button type="button"
                    id="add-medicine"
                    class="btn btn-sm btn-outline-primary"
                    @disabled($medicines->isEmpty())>
                    + Add Medicine
                </button>
            </div>

            <div class="card-body">
                @if($medicines->isEmpty())
                <div class="alert alert-warning mb-0">
                    No medicines are available in the database.
                </div>
                @else
                <p class="text-muted small mb-4">
                    Add each medicine separately and complete all required fields.
                </p>

                <div id="medicine-items">
                    <div class="medicine-item border rounded-3 p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="h6 fw-bold mb-0 medicine-heading">
                                Medicine 1
                            </h3>

                            <button type="button"
                                class="btn btn-sm btn-outline-danger remove-medicine">
                                Remove
                            </button>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">
                                    Medicine <span class="text-danger">*</span>
                                </label>

                                <select name="items[0][medicine_id]"
                                    class="form-select"
                                    required>
                                    <option value="">Select a medicine</option>

                                    @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}"
                                        @selected((string) old('items.0.medicine_id')===(string) $medicine->id)>
                                        {{ $medicine->name }}
                                        @if($medicine->generic_name)
                                        — {{ $medicine->generic_name }}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Dosage <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="items[0][dosage]"
                                    class="form-control"
                                    placeholder="e.g. 500 mg"
                                    value="{{ old('items.0.dosage') }}"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Frequency <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="items[0][frequency]"
                                    class="form-control"
                                    placeholder="e.g. Twice daily"
                                    value="{{ old('items.0.frequency') }}"
                                    required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    Duration <span class="text-danger">*</span>
                                </label>

                                <input type="text"
                                    name="items[0][duration]"
                                    class="form-control"
                                    placeholder="e.g. 7 days"
                                    value="{{ old('items.0.duration') }}"
                                    required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Instructions</label>

                                <textarea name="items[0][instructions]"
                                    class="form-control"
                                    rows="2"
                                    placeholder="Additional instructions (optional)">{{ old('items.0.instructions') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Form actions --}}
        <div class="d-flex flex-wrap justify-content-end gap-2">
            <a href="{{ route('prescriptions.index') }}"
                class="btn btn-light border">
                Cancel
            </a>

            <button type="submit"
                class="btn btn-primary"
                @disabled($appointments->isEmpty() || $medicines->isEmpty())>
                Create Prescription
            </button>
        </div>
    </form>
</div>

<
    <script>
    const medicines = @json(
    $medicines->map(function ($medicine) {
    return [
    'id' => $medicine->id,
    'label' => $medicine->name . (
    $medicine->generic_name
    ? ' - ' . $medicine->generic_name
    : ''
    ),
    ];
    })->values()
    );

    const medicineItems = document.getElementById('medicine-items');
    const addMedicineButton = document.getElementById('add-medicine');

    let itemIndex = 1;

    function updateMedicineHeadings() {
    const items = medicineItems.querySelectorAll('.medicine-item');

    items.forEach((item, index) => {
    item.querySelector('.medicine-heading').textContent =
    `Medicine ${index + 1}`;

    item.querySelector('.remove-medicine').disabled =
    items.length === 1;
    });
    }

    addMedicineButton?.addEventListener('click', function() {
    const item = document.createElement('div');
    item.className = 'medicine-item border rounded-3 p-3 mb-3';

    const headingRow = document.createElement('div');
    headingRow.className =
    'd-flex justify-content-between align-items-center mb-3';

    const heading = document.createElement('h3');
    heading.className = 'h6 fw-bold mb-0 medicine-heading';

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-sm btn-outline-danger remove-medicine';
    removeButton.textContent = 'Remove';

    headingRow.append(heading, removeButton);

    const row = document.createElement('div');
    row.className = 'row g-3';

    function createField(labelText, name, placeholder, type = 'text') {
    const column = document.createElement('div');
    column.className = 'col-md-4';

    const label = document.createElement('label');
    label.className = 'form-label';
    label.textContent = labelText;

    const input = document.createElement('input');
    input.type = type;
    input.name = name;
    input.className = 'form-control';
    input.placeholder = placeholder;
    input.required = true;

    column.append(label, input);
    return column;
    }

    const medicineColumn = document.createElement('div');
    medicineColumn.className = 'col-12';

    const medicineLabel = document.createElement('label');
    medicineLabel.className = 'form-label';
    medicineLabel.textContent = 'Medicine';

    const select = document.createElement('select');
    select.name = `items[${itemIndex}][medicine_id]`;
    select.className = 'form-select';
    select.required = true;

    const placeholderOption = document.createElement('option');
    placeholderOption.value = '';
    placeholderOption.textContent = 'Select a medicine';
    select.appendChild(placeholderOption);

    medicines.forEach(function(medicine) {
    const option = document.createElement('option');
    option.value = medicine.id;
    option.textContent = medicine.label;
    select.appendChild(option);
    });

    medicineColumn.append(medicineLabel, select);

    row.append(
    medicineColumn,
    createField('Dosage', `items[${itemIndex}][dosage]`, 'e.g. 500 mg'),
    createField('Frequency', `items[${itemIndex}][frequency]`, 'e.g. Twice daily'),
    createField('Duration', `items[${itemIndex}][duration]`, 'e.g. 7 days')
    );

    const instructionsColumn = document.createElement('div');
    instructionsColumn.className = 'col-12';

    const instructionsLabel = document.createElement('label');
    instructionsLabel.className = 'form-label';
    instructionsLabel.textContent = 'Instructions';

    const instructions = document.createElement('textarea');
    instructions.name = `items[${itemIndex}][instructions]`;
    instructions.className = 'form-control';
    instructions.rows = 2;
    instructions.placeholder = 'Additional instructions (optional)';

    instructionsColumn.append(instructionsLabel, instructions);
    row.appendChild(instructionsColumn);

    item.append(headingRow, row);
    medicineItems.appendChild(item);

    itemIndex++;
    updateMedicineHeadings();
    });

    medicineItems?.addEventListener('click', function(event) {
    const button = event.target.closest('.remove-medicine');

    if (!button || medicineItems.querySelectorAll('.medicine-item').length <= 1) {
        return;
        }

        button.closest('.medicine-item').remove();
        updateMedicineHeadings();
        });

        if (medicineItems) {
        updateMedicineHeadings();
        }
        </script>
        @endsection