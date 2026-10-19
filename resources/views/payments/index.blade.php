 @extends('layouts.app')

 @section('title', 'Payments | MediCore')

 @section('content')

 @php
 $paidCount = $payments->where('status', 'paid')->count();
 $pendingCount = $payments->where('status', 'pending')->count();
 $paidTotal = $payments->where('status', 'paid')->sum('amount');
 $role = strtolower(auth()->user()->role?->name ?? '');
 @endphp

 <div class="container-fluid px-0">

     {{-- Page heading --}}
     <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
         <div>
             <h2 class="fw-bold mb-1">Payments</h2>
             <p class="text-muted mb-0">
                 Manage and review appointment payments.
             </p>
         </div>

         @if($role === 'patient')
         <a href="{{ route('payments.create') }}" class="btn btn-primary px-4">
             + Create Payment
         </a>
         @endif
     </div>

     {{-- Summary cards --}}
     <div class="row g-3 mb-4">

         <div class="col-12 col-md-4">
             <div class="card border-0 shadow-sm h-100">
                 <div class="card-body p-4">
                     <p class="text-muted small mb-2">Total Payments</p>
                     <h3 class="fw-bold mb-0">{{ $payments->count() }}</h3>
                     <small class="text-muted">Payments in this list</small>
                 </div>
             </div>
         </div>

         <div class="col-12 col-md-4">
             <div class="card border-0 shadow-sm h-100">
                 <div class="card-body p-4">
                     <p class="text-muted small mb-2">Successfully Paid</p>
                     <h3 class="fw-bold text-success mb-0">
                         {{ number_format((float) $paidTotal, 2) }}
                     </h3>
                     <small class="text-muted">
                         {{ $paidCount }} paid {{ $paidCount === 1 ? 'payment' : 'payments' }}
                     </small>
                 </div>
             </div>
         </div>

         <div class="col-12 col-md-4">
             <div class="card border-0 shadow-sm h-100">
                 <div class="card-body p-4">
                     <p class="text-muted small mb-2">Pending Payments</p>
                     <h3 class="fw-bold text-warning mb-0">{{ $pendingCount }}</h3>
                     <small class="text-muted">Awaiting payment completion</small>
                 </div>
             </div>
         </div>

     </div>

     {{-- Payment table --}}
     <div class="card border-0 shadow-sm">

         <div class="card-header bg-white border-0 p-4">
             <h5 class="fw-semibold mb-1">Payment Records</h5>
             <p class="text-muted small mb-0">
                 View payment details, methods and current statuses.
             </p>
         </div>

         @if($payments->isEmpty())

         <div class="card-body text-center py-5">
             <h5 class="fw-semibold">No payments found</h5>
             <p class="text-muted mb-3">
                 Payment records will appear here when available.
             </p>

             @if($role === 'patient')
             <a href="{{ route('payments.create') }}" class="btn btn-primary">
                 Create Your First Payment
             </a>
             @endif
         </div>

         @else

         <div class="table-responsive">
             <table class="table table-hover align-middle mb-0">

                 <thead class="table-light">
                     <tr>
                         <th class="px-4 py-3">Payment</th>
                         <th class="py-3">Patient</th>
                         <th class="py-3">Doctor</th>
                         <th class="py-3">Appointment Date</th>
                         <th class="py-3">Amount</th>
                         <th class="py-3">Method</th>
                         <th class="py-3">Status</th>
                         <th class="py-3">Paid At</th>
                         <th class="px-4 py-3 text-end">Action</th>
                     </tr>
                 </thead>

                 <tbody>
                     @foreach($payments as $payment)
                     <tr>
                         <td class="px-4">
                             <span class="fw-semibold">#{{ $payment->id }}</span>
                         </td>

                         <td>
                             <div class="fw-medium">
                                 {{ trim(($payment->patient?->user?->first_name ?? '') . ' ' . ($payment->patient?->user?->last_name ?? '')) ?: 'Unknown' }}
                             </div>
                         </td>

                         <td>
                             {{ trim(($payment->appointment?->doctor?->user?->first_name ?? '') . ' ' . ($payment->appointment?->doctor?->user?->last_name ?? '')) ?: 'Unknown' }}
                         </td>

                         <td>
                             {{ $payment->appointment?->appointment_date?->format('Y-m-d') ?? '—' }}
                         </td>

                         <td class="fw-semibold text-nowrap">
                             {{ number_format((float) $payment->amount, 2) }}$
                         </td>

                         <td>
                             {{ ucfirst($payment->method ?? '—') }}
                         </td>

                         <td>
                             @switch($payment->status)
                             @case('paid')
                             <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">Paid</span>
                             @break

                             @case('pending')
                             <span class="badge rounded-pill bg-warning-subtle text-dark px-3 py-2">Pending</span>
                             @break

                             @case('failed')
                             <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">Failed</span>
                             @break

                             @case('refunded')
                             <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-2">Refunded</span>
                             @break

                             @default
                             <span class="badge bg-light text-dark">{{ ucfirst($payment->status ?? 'Unknown') }}</span>
                             @endswitch
                         </td>

                         <td class="text-nowrap">
                             {{ $payment->paid_at?->format('Y-m-d H:i') ?? '—' }}
                         </td>

                         <td class="px-4 text-end">
                             <a href="{{ route('payments.show', $payment) }}"
                                 class="btn btn-sm btn-outline-primary">
                                 View Details
                             </a>
                         </td>
                     </tr>
                     @endforeach
                 </tbody>

             </table>
         </div>

         <div class="card-footer bg-white border-0 px-4 py-3">
             <small class="text-muted">
                 Showing {{ $payments->count() }} {{ $payments->count() === 1 ? 'payment' : 'payments' }}
             </small>
         </div>

         @endif

     </div>

 </div>

 @endsection