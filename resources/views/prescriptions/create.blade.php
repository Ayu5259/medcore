<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Prescription</title>
</head>

<body>

    <h1>Create Prescription</h1>


    @if ($errors->any())

    <div>

        <strong>
            Please fix the following errors:
        </strong>

        <ul>

            @foreach ($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

            @endforeach

        </ul>

    </div>

    @endif


    <form
        method="POST"
        action="{{ route('prescriptions.store') }}">

        @csrf


        <h2>Appointment</h2>

        <p>

            <label for="appointment_id">
                Appointment:
            </label>

            <select
                name="appointment_id"
                id="appointment_id"
                required>

                <option value="">
                    Select an appointment
                </option>

                @foreach ($appointments as $appointment)

                <option
                    value="{{ $appointment->id }}"
                    @selected(old('appointment_id')==$appointment->id)
                    >

                    #{{ $appointment->id }}
                    -
                    {{ $appointment->patient->user->first_name }}
                    {{ $appointment->patient->user->last_name }}
                    -
                    {{ $appointment->appointment_date->format('Y-m-d') }}

                </option>

                @endforeach

            </select>

        </p>


        <h2>Medicines</h2>


        <div id="medicine-items">

            <fieldset class="medicine-item">

                <legend>
                    Medicine 1
                </legend>


                <p>

                    <label>
                        Medicine:
                    </label>

                    <select
                        name="items[0][medicine_id]"
                        required>

                        <option value="">
                            Select a medicine
                        </option>

                        @foreach ($medicines as $medicine)

                        <option
                            value="{{ $medicine->id }}"
                            @selected(old('items.0.medicine_id')==$medicine->id)
                            >

                            {{ $medicine->name }}
                            -
                            {{ $medicine->generic_name }}

                        </option>

                        @endforeach

                    </select>

                </p>


                <p>

                    <label>
                        Dosage:
                    </label>

                    <input
                        type="text"
                        name="items[0][dosage]"
                        value="{{ old('items.0.dosage') }}"
                        required>

                </p>


                <p>

                    <label>
                        Frequency:
                    </label>

                    <input
                        type="text"
                        name="items[0][frequency]"
                        value="{{ old('items.0.frequency') }}"
                        required>

                </p>


                <p>

                    <label>
                        Duration:
                    </label>

                    <input
                        type="text"
                        name="items[0][duration]"
                        value="{{ old('items.0.duration') }}"
                        required>

                </p>


                <p>

                    <label>
                        Instructions:
                    </label>

                    <textarea
                        name="items[0][instructions]">{{ old('items.0.instructions') }}</textarea>

                </p>


                <button
                    type="button"
                    class="remove-medicine">
                    Remove
                </button>

            </fieldset>

        </div>


        <br>


        <button
            type="button"
            id="add-medicine">
            + Add Medicine
        </button>


        <br>
        <br>


        <button type="submit">
            Create Prescription
        </button>

    </form>


    <p>

        <a href="{{ route('appointments.index') }}">
            Back to Appointments
        </a>

    </p>


    {{-- Medicine data for JavaScript --}}

    <script
        type="application/json"
        id="medicines-data">
        @json($medicines)
    </script>


    <script>
        const medicines =
            JSON.parse(
                document.getElementById('medicines-data').textContent
            );


        const medicineItems =
            document.getElementById('medicine-items');


        const addMedicineButton =
            document.getElementById('add-medicine');


        let itemIndex = 1;


        addMedicineButton.addEventListener(
            'click',
            function() {

                const fieldset =
                    document.createElement('fieldset');


                fieldset.classList.add(
                    'medicine-item'
                );


                fieldset.innerHTML = `

                    <legend>
                        Medicine ${itemIndex + 1}
                    </legend>


                    <p>

                        <label>
                            Medicine:
                        </label>

                        <select
                            name="items[${itemIndex}][medicine_id]"
                            required
                        >

                            <option value="">
                                Select a medicine
                            </option>

                            ${medicines.map(medicine => `

                                <option
                                    value="${medicine.id}"
                                >

                                    ${medicine.name}
                                    -
                                    ${medicine.generic_name}

                                </option>

                            `).join('')}

                        </select>

                    </p>


                    <p>

                        <label>
                            Dosage:
                        </label>

                        <input
                            type="text"
                            name="items[${itemIndex}][dosage]"
                            required
                        >

                    </p>


                    <p>

                        <label>
                            Frequency:
                        </label>

                        <input
                            type="text"
                            name="items[${itemIndex}][frequency]"
                            required
                        >

                    </p>


                    <p>

                        <label>
                            Duration:
                        </label>

                        <input
                            type="text"
                            name="items[${itemIndex}][duration]"
                            required
                        >

                    </p>


                    <p>

                        <label>
                            Instructions:
                        </label>

                        <textarea
                            name="items[${itemIndex}][instructions]"
                        ></textarea>

                    </p>


                    <button
                        type="button"
                        class="remove-medicine"
                    >
                        Remove
                    </button>

                `;


                medicineItems.appendChild(
                    fieldset
                );


                itemIndex++;

            }
        );


        medicineItems.addEventListener(
            'click',
            function(event) {

                if (
                    event.target.classList.contains(
                        'remove-medicine'
                    )
                ) {

                    const items =
                        medicineItems.querySelectorAll(
                            '.medicine-item'
                        );


                    if (items.length > 1) {

                        event.target
                            .closest('.medicine-item')
                            .remove();

                    }

                }

            }
        );
    </script>

</body>

</html>