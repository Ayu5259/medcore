 @extends('layouts.app')

 @section('title', 'Payment History | MediCore')

 @section('content')
 @php
 $paidCount = $payments->where('status', 'paid')->count();
 $pendingCount = $payments->where('status', 'pending')->count();
 $failedCount = $payments->where('status', 'failed')->count();
 $paidTotal = $payments->where('status', 'paid')->sum('amount');
 @endphp

 <div class="container-fluid px-0">

     {{-- Page heading --}}
     <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
         <div>
             <h2 class="fw-bold mb-1">Payment History</h2>
             <p class="text-muted mb-0">
                 Review payments associated with your appointments.
             </p>
         </div>

         <a href="{{ route('payments.index') }}" class="btn btn-outline-primary">
             <i class="bi bi-arrow-left me-1"></i>
             Back to Payments
         </a>
     </div>

     {{-- Success message --}}
     @if(session('success'))
     <div class="alert alert-success alert-dismissible fade show" role="alert">
         {{ session('success') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
     </div>
     @endif

     {{-- Summary cards --}}
     <div class="row g-3 mb-4">

         <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 shadow-sm h-100">
                 <div class="card-body d-flex justify-content-between align-items-center">
                     <div>
                         <p class="text-muted small mb-1">Total Payments</p>
                         <h3 class="fw-bold mb-0">{{ $payments->count() }}</h3>
                     </div>
                     <div class="rounded-3 bg-primary-subtle text-primary p-3">
                         <i class="bi bi-receipt fs-4"></i>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 shadow-sm h-100">
                 <div class="card-body d-flex justify-content-between align-items-center">
                     <div>
                         <p class="text-muted small mb-1">Successful Payments</p>
                         <h3 class="fw-bold text-success mb-0">{{ $paidCount }}</h3>
                     </div>
                     <div class="rounded-3 bg-success-subtle text-success p-3">
                         <i class="bi bi-check-circle fs-4"></i>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 shadow-sm h-100">
                 <div class="card-body d-flex justify-content-between align-items-center">
                     <div>
                         <p class="text-muted small mb-1">Pending Payments</p>
                         <h3 class="fw-bold text-warning mb-0">{{ $pendingCount }}</h3>
                     </div>
                     <div class="rounded-3 bg-warning-subtle text-warning p-3">
                         <i class="bi bi-hourglass-split fs-4"></i>
                     </div>
                 </div>
             </div>
         </div>

         <div class="col-12 col-sm-6 col-xl-3">
             <div class="card border-0 shadow-sm h-100">
                 <div class="card-body d-flex justify-content-between align-items-center">
                     <div>
                         <p class="text-muted small mb-1">Successful Amount</p>
                         <h3 class="fw-bold mb-0">{{ number_format((float) $paidTotal, 2) }}$</h3>
                     </div>
                     <div class="rounded-3 bg-info-subtle text-info p-3">
                         <i class="bi bi-cash-stack fs-4"></i>
                     </div>
                 </div>
             </div>
         </div>

     </div>

     {{-- Payment history table --}}
     <div class="card border-0 shadow-sm">

         <div class="card-header bg-white border-0 pt-4 px-4">
             <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                 <div>
                     <h5 class="fw-bold mb-1">Payment Records</h5>
                     <p class="text-muted small mb-0">
                         All payments linked to your appointments.
                     </p>
                 </div>

                 <span class="badge text-bg-light border">
                     {{ $payments->count() }} records
                 </span>
             </div>
         </div>

         <div class="card-body px-0 pb-0">

             @if($payments->isEmpty())

             <div class="text-center py-5 px-3">
                 <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3"
                     style="width: 72px; height: 72px;">
                     <i class="bi bi-receipt text-secondary fs-2"></i>
                 </div>

                 <h5 class="fw-semibold">No payment history yet</h5>
                 <p class="text-muted mb-0">
                     Payments related to your appointments will appear here.
                 </p>
             </div>

             @else

             <div class="table-responsive">
                 <table class="table table-hover align-middle mb-0">

                     <thead class="table-light">
                         <tr>
                             <th class="ps-4">Payment</th>
                             <th>Patient</th>
                             <th>Appointment Date</th>
                             <th>Amount</th>
                             <th>Method</th>
                             <th>Status</th>
                             <th>Paid At</th>
                             <th class="text-end pe-4">Action</th>
                         </tr>
                     </thead>

                     <tbody>
                         @foreach($payments as $payment)
                         <tr>
                             <td class="ps-4">
                                 <span class="fw-semibold">#{{ $payment->id }}</span>
                             </td>

                             <td>
                                 <div class="fw-medium">
                                     {{ trim(
            ($payment->patient?->user?->first_name ?? '') . ' ' .
            ($payment->patient?->user?->last_name ?? '')
        ) ?: 'Unknown patient'  }}
                                 </div>
                                 <small class="text-muted">Patient</small>
                             </td>

                             <td>
                                 {{ $payment->appointment?->appointment_date?->format('Y-m-d') ?? 'N/A' }}
                             </td>

                             <td class="fw-semibold text-nowrap">
                                 {{ number_format((float) $payment->amount, 2) }}$
                             </td>

                             <td>
                                 {{ ucfirst($payment->method ?? 'N/A') }}
                             </td>

                             <td>
                                 @switch($payment->status)
                                 @case('paid')
                                 <span class="badge rounded-pill text-bg-success">Paid</span>
                                 @break

                                 @case('pending')
                                 <span class="badge rounded-pill text-bg-warning">Pending</span>
                                 @break

                                 @case('failed')
                                 <span class="badge rounded-pill text-bg-danger">Failed</span>
                                 @break

                                 @case('refunded')
                                 <span class="badge rounded-pill text-bg-secondary">Refunded</span>
                                 @break

                                 @default
                                 <span class="badge rounded-pill text-bg-light border text-dark">
                                     {{ ucfirst($payment->status ?? 'Unknown') }}
                                 </span>
                                 @endswitch
                             </td>

                             <td class="text-nowrap">
                                 {{ $payment->paid_at?->format('Y-m-d H:i') ?? '—' }}
                             </td>

                             <td class="text-end pe-4">
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

             @endif
         </div>
     </div>

     <p class="text-muted small mt-3 mb-0">
         Payment history is limited to appointments assigned to your doctor account.
     </p>

 </div>
 @endsection