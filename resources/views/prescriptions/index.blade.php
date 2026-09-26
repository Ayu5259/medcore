@extends('layouts.app')

@section('title', 'Prescriptions')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h1>
        Prescriptions
    </h1>


    @if(auth()->user()->role->name === 'Doctor')

    <a href="{{ route('prescriptions.create') }}"
        class="btn btn-primary">
        Create Prescription
    </a>

    @endif

</div>


<div class="card shadow-sm">

    <div class="card-body">


        @if($prescriptions->isEmpty())

        <div class="alert alert-info">
            No prescriptions found.
        </div>

        @else

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>
                            Doctor
                        </th>

                        <th>
                            Patient
                        </th>

                        <th>
                            Medicines
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($prescriptions as $prescription)

                    <tr>

                        <td>
                            {{ $prescription->appointment->doctor->user->first_name }}
                            {{ $prescription->appointment->doctor->user->last_name }}
                        </td>


                        <td>
                            {{ $prescription->appointment->patient->user->first_name }}
                            {{ $prescription->appointment->patient->user->last_name }}
                        </td>


                        <td>
                            {{ $prescription->prescriptionItems->count() }}
                        </td>


                        <td>

                            <a href="{{ route('prescriptions.show', $prescription) }}"
                                class="btn btn-sm btn-outline-primary">
                                View
                            </a>

                        </td>


                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @endif


    </div>

</div>

@endsection