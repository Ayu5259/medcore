 @extends('layouts.app')

 @section('title', 'Appointments')

 @section('content')
 @php
 $totalAppointments = $appointments->count();
 $pendingAppointments = $appointments->where('status', 'pending')->count();
 $confirmedAppointments = $appointments->where('status', 'confirmed')->count();
 $cancelledAppointments = $appointments->where('status', 'cancelled')->count();

 $user = auth()->user();
 $isDoctor = $user && $user->doctor;
 @endphp

 <div class="container py-4 py-lg-5">

     {{-- Page header --}}
     <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
         <div>
             <div class="small text-primary text-uppercase fw-semibold mb-2">
                 MediCore / Patient Management
             </div>

             <h1 class="h2 fw-bold mb-2">Appointments</h1>

             <p class="text-secondary mb-0">
                 Manage and review your scheduled appointments.
             </p>
         </div>

         @can('create', App\Models\Appointment::class)
         <a href="{{ route('appointments.create') }}"
             class="btn btn-primary px-4 py-2">
             + Create Appointment
         </a>
         @endcan
     </div>

     {{-- Summary cards --}}
     <div class="row g-3 mb-4">

         <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                 <div class="card-body p-4">
                     <div class="small text-secondary mb-2">Total Appointments</div>
                     <div class="h2 fw-bold mb-0">{{ $totalAppointments }}</div>
                     <div class="small text-secondary mt-2">All your appointments</div>
                 </div>
             </div>
         </div>

         <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                 <div class="card-body p-4">
                     <div class="small text-secondary mb-2">Pending</div>
                     <div class="h2 fw-bold text-warning mb-0">{{ $pendingAppointments }}</div>
                     <div class="small text-secondary mt-2">Awaiting confirmation</div>
                 </div>
             </div>
         </div>

         <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                 <div class="card-body p-4">
                     <div class="small text-secondary mb-2">Confirmed</div>
                     <div class="h2 fw-bold text-success mb-0">{{ $confirmedAppointments }}</div>
                     <div class="small text-secondary mt-2">Confirmed bookings</div>
                 </div>
             </div>
         </div>

         <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 shadow-sm rounded-4 h-100">
                 <div class="card-body p-4">
                     <div class="small text-secondary mb-2">Cancelled</div>
                     <div class="h2 fw-bold text-danger mb-0">{{ $cancelledAppointments }}</div>
                     <div class="small text-secondary mt-2">Cancelled bookings</div>
                 </div>
             </div>
         </div>

     </div>

     {{-- Appointment list --}}
     <div class="card border-0 shadow-sm rounded-4">

         <div class="card-header bg-white border-0 px-4 pt-4 pb-3">
             <h2 class="h5 fw-bold mb-1">Appointment List</h2>
             <p class="small text-secondary mb-0">
                 Review appointment details and booking status.
             </p>
         </div>

         <div class="card-body p-0">

             @if ($appointments->isEmpty())

             <div class="text-center py-5 px-4">
                 <div class="display-6 text-secondary mb-3">—</div>

                 <h3 class="h5 fw-bold">No Appointments Yet</h3>

                 <p class="text-secondary mb-4">
                     Your appointment list is currently empty.
                 </p>

                 @can('create', App\Models\Appointment::class)
                 <a href="{{ route('appointments.create') }}"
                     class="btn btn-primary">
                     Create Your First Appointment
                 </a>
                 @endcan
             </div>

             @else

             {{-- Desktop table --}}
             <div class="table-responsive d-none d-md-block">
                 <table class="table align-middle mb-0">
                     <thead class="table-light">
                         <tr>
                             <th class="px-4 py-3">Appointment</th>
                             <th class="py-3">Patient</th>
                             <th class="py-3">Doctor</th>
                             <th class="py-3">Date &amp; Time</th>
                             <th class="py-3">Status</th>
                             <th class="py-3 text-end pe-4">Action</th>
                         </tr>
                     </thead>

                     <tbody>
                         @foreach ($appointments as $appointment)
                         @php
                         $statusStyles = [
                         'pending' => 'text-bg-warning',
                         'confirmed' => 'text-bg-success',
                         'cancelled' => 'text-bg-danger',
                         'completed' => 'text-bg-primary',
                         ];

                         $statusClass = $statusStyles[$appointment->status]
                         ?? 'text-bg-secondary';
                         @endphp

                         <tr>
                             <td class="px-4 py-3">
                                 <div class="fw-semibold">
                                     #{{ $appointment->id }}
                                 </div>
                                 <div class="small text-secondary">
                                     {{ $appointment->visit_type ?? 'Appointment' }}
                                 </div>
                             </td>

                             <td class="py-3">
                                 <div class="fw-semibold">
                                     {{ $appointment->patient?->user?->first_name }}
                                     {{ $appointment->patient?->user?->last_name }}
                                 </div>
                             </td>

                             <td class="py-3">
                                 <div class="fw-semibold">
                                     {{ $appointment->doctor?->user?->first_name }}
                                     {{ $appointment->doctor?->user?->last_name }}
                                 </div>
                             </td>

                             <td class="py-3">
                                 <div class="fw-semibold">
                                     {{ $appointment->appointment_date->format('Y-m-d') }}
                                 </div>
                                 <div class="small text-secondary">
                                     {{ \Carbon\Carbon::parse($appointment->appointment_start_time)->format('H:i') }}
                                     –
                                     {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('H:i') }}
                                 </div>
                             </td>

                             <td class="py-3">
                                 <span class="badge rounded-pill {{ $statusClass }} px-3 py-2">
                                     {{ ucfirst($appointment->status) }}
                                 </span>
                             </td>

                             <td class="py-3 text-end pe-4">
                                 <a href="{{ route('appointments.show', $appointment) }}"
                                     class="btn btn-sm btn-outline-primary">
                                     View Details
                                 </a>
                             </td>
                         </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>

             {{-- Mobile cards --}}
             <div class="d-md-none p-3">
                 @foreach ($appointments as $appointment)
                 @php
                 $statusStyles = [
                 'pending' => 'text-bg-warning',
                 'confirmed' => 'text-bg-success',
                 'cancelled' => 'text-bg-danger',
                 'completed' => 'text-bg-primary',
                 ];

                 $statusClass = $statusStyles[$appointment->status]
                 ?? 'text-bg-secondary';
                 @endphp

                 <div class="border rounded-4 p-3 mb-3">
                     <div class="d-flex justify-content-between align-items-start gap-2 mb-3">
                         <div>
                             <div class="fw-bold">
                                 Appointment #{{ $appointment->id }}
                             </div>
                             <div class="small text-secondary">
                                 {{ $appointment->appointment_date->format('Y-m-d') }}
                             </div>
                         </div>

                         <span class="badge rounded-pill {{ $statusClass }}">
                             {{ ucfirst($appointment->status) }}
                         </span>
                     </div>

                     <div class="small mb-2">
                         <span class="text-secondary">Patient:</span>
                         {{ $appointment->patient?->user?->first_name }}
                         {{ $appointment->patient?->user?->last_name }}
                     </div>

                     <div class="small mb-2">
                         <span class="text-secondary">Doctor:</span>
                         {{ $appointment->doctor?->user?->first_name }}
                         {{ $appointment->doctor?->user?->last_name }}
                     </div>

                     <div class="small mb-3">
                         <span class="text-secondary">Time:</span>
                         {{ \Carbon\Carbon::parse($appointment->appointment_start_time)->format('H:i') }}
                         –
                         {{ \Carbon\Carbon::parse($appointment->appointment_end_time)->format('H:i') }}
                     </div>

                     <a href="{{ route('appointments.show', $appointment) }}"
                         class="btn btn-outline-primary btn-sm w-100">
                         View Details
                     </a>
                 </div>
                 @endforeach
             </div>

             @endif

         </div>
     </div>

 </div>
 @endsection