@extends('layouts.app')

@section('title', 'Medical Records')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h1>
        Medical Records
    </h1>

</div>


<div class="card shadow-sm">

    <div class="card-body">


        @if($medicalRecords->isEmpty())

        <div class="alert alert-info">
            No medical records found.
        </div>


        @else

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>
                            Patient
                        </th>

                        <th>
                            National Code
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($medicalRecords as $record)

                    <tr>

                        <td>
                            {{ $record->patient->user->first_name }}
                            {{ $record->patient->user->last_name }}
                        </td>


                        <td>
                            {{ $record->patient->user->national_code }}
                        </td>


                        <td>

                            <a href="{{ route('medical_records.show', $record) }}"
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