<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Edit Prescription #{{ $prescription->id }}
    </title>
</head>

<body>

    <h1>
        Edit Prescription #{{ $prescription->id }}
    </h1>


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


    <h2>Patient</h2>

    <p>

        {{ $prescription->appointment->patient->user->first_name }}
        {{ $prescription->appointment->patient->user->last_name }}

    </p>


    <form
        method="POST"
        action="{{ route('prescriptions.update', $prescription) }}">

        @csrf

        @method('PUT')


        <h2>Medicines</h2>


        <div
            id="medicine-items"
            data-item-count="{{ $prescription->prescriptionItems->count() }}">

            @foreach (
            $prescription->prescriptionItems
            as $index => $item
            )

            <fieldset class="medicine-item">

                <legend>
                    Medicine {{ $index + 1 }}
                </legend>


                <p>

                    <label>
                        Medicine:
                    </label>

                    <select
                        name="items[{{ $index }}][medicine_id]"
                        required>

                        <option value="">
                            Select a medicine
                        </option>


                        @foreach ($medicines as $medicine)

                        <option
                            value="{{ $medicine->id }}"
                            @selected(
                            $item->medicine_id == $medicine->id
                            )
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
                        name="items[{{ $index }}][dosage]"
                        value="{{ $item->dosage }}"
                        required>

                </p>


                <p>

                    <label>
                        Frequency:
                    </label>

                    <input
                        type="text"
                        name="items[{{ $index }}][frequency]"
                        value="{{ $item->frequency }}"
                        required>

                </p>


                <p>

                    <label>
                        Duration:
                    </label>

                    <input
                        type="text"
                        name="items[{{ $index }}][duration]"
                        value="{{ $item->duration }}"
                        required>

                </p>


                <p>

                    <label>
                        Instructions:
                    </label>

                    <textarea
                        name="items[{{ $index }}][instructions]">{{ $item->instructions }}</textarea>

                </p>


                <button
                    type="button"
                    class="remove-medicine">
                    Remove
                </button>

            </fieldset>


            <br>

            @endforeach

        </div>


        <button
            type="button"
            id="add-medicine">
            + Add Medicine
        </button>


        <br>
        <br>


        <button type="submit">
            Update Prescription
        </button>

    </form>


    <p>

        <a href="{{ route('prescriptions.show', $prescription) }}">
            Cancel
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


        let itemIndex =
            Number(
                medicineItems.dataset.itemCount
            );


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