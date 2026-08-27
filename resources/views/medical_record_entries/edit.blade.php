<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Medical Record Entry</title>
</head>

<body>

    <h1>Edit Medical Record Entry</h1>

    @if ($errors->any())
    <div>
        <strong>Please fix the following errors:</strong>

        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form
        method="POST"
        action="{{ route('medical-record-entries.update', $medicalRecordEntry) }}">

        @csrf
        @method('PUT')

        <div>
            <label for="diagnosis">
                Diagnosis
            </label>

            <textarea
                name="diagnosis"
                id="diagnosis"
                required>{{ old('diagnosis', $medicalRecordEntry->diagnosis) }}</textarea>
        </div>

        <br>

        <div>
            <label for="treatment">
                Treatment
            </label>

            <textarea
                name="treatment"
                id="treatment">{{ old('treatment', $medicalRecordEntry->treatment) }}</textarea>
        </div>

        <br>

        <div>
            <label for="notes">
                Notes
            </label>

            <textarea
                name="notes"
                id="notes">{{ old('notes', $medicalRecordEntry->notes) }}</textarea>
        </div>

        <br>

        <button type="submit">
            Update Entry
        </button>

    </form>

    <br>

    <a href="{{ route('medical-record-entries.show', $medicalRecordEntry) }}">
        Cancel
    </a>

</body>

</html>