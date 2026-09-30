@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Patients</h2>
            <p class="text-muted mb-0">
                List of patients
            </p>
        </div>

        <a href="#" class="btn btn-primary">
            Add Patient
        </a>
    </div>

    @if($patients->count())
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>

                            <td>
                                {{ $patient->user->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $patient->user->email ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $patient->user->phone ?? 'N/A' }}
                            </td>

                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <div class="mt-3">
        {{ $patients->links() }}
    </div>

    @else
    <div class="alert alert-info">
        No patients found.
    </div>
    @endif

</div>
@endsection