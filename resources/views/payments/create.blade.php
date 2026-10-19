 @extends('layouts.app')

 @section('title', 'Create Payment | MediCore')

 @section('content')

 <div class="container-fluid px-0">

     {{-- Page heading --}}
     <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
         <div>
             <h2 class="fw-bold mb-1">Create Payment</h2>
             <p class="text-muted mb-0">
                 Create a payment record for one of your appointments.
             </p>
         </div>

         <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary">
             Back to Payments
         </a>
     </div>

     <div class="row g-4">

         {{-- Main form --}}
         <div class="col-12 col-xl-8">

             <div class="card border-0 shadow-sm">

                 <div class="card-header bg-white border-0 px-4 pt-4">
                     <h5 class="fw-semibold mb-1">Payment Information</h5>
                     <p class="text-muted small mb-0">
                         Complete the required fields below.
                     </p>
                 </div>

                 <div class="card-body p-4">

                     {{-- Validation errors --}}
                     @if($errors->any())
                     <div class="alert alert-danger mb-4">
                         <h6 class="fw-semibold">Please check your information</h6>
                         <ul class="mb-0">
                             @foreach($errors->all() as $error)
                             <li>{{ $error }}</li>
                             @endforeach
                         </ul>
                     </div>
                     @endif

                     @if($appointments->isEmpty())

                     <div class="text-center py-5">
                         <h5 class="fw-semibold mb-2">No appointments available</h5>
                         <p class="text-muted mb-4">
                             All your appointments may already have payment records.
                         </p>

                         <a href="{{ route('payments.index') }}" class="btn btn-primary">
                             Return to Payments
                         </a>
                     </div>

                     @else

                     <form method="POST" action="{{ route('payments.store') }}">
                         @csrf

                         {{-- Appointment selection --}}
                         <div class="mb-4">
                             <label for="appointment_id" class="form-label fw-semibold">
                                 Select Appointment <span class="text-danger">*</span>
                             </label>

                             <select
                                 name="appointment_id"
                                 id="appointment_id"
                                 class="form-select @error('appointment_id') is-invalid @enderror"
                                 required>

                                 <option value="">Choose an appointment</option>

                                 @foreach($appointments as $appointment)
                                 <option
                                     value="{{ $appointment->id }}"
                                     {{ (string) old('appointment_id') === (string) $appointment->id ? 'selected' : '' }}>

                                     Appointment #{{ $appointment->id }}
                                     — Dr. {{ trim(($appointment->doctor?->user?->first_name ?? '') . ' ' . ($appointment->doctor?->user?->last_name ?? '')) ?: 'Unknown' }}
                                     — {{ $appointment->appointment_date?->format('Y-m-d') ?? 'Date unavailable' }}
                                     — {{ $appointment->appointment_start_time }}

                                 </option>
                                 @endforeach

                             </select>

                             @error('appointment_id')
                             <div class="invalid-feedback">{{ $message }}</div>
                             @enderror

                             <div class="form-text">
                                 Only appointments without an existing payment are listed.
                             </div>
                         </div>

                         {{-- Amount --}}
                         <div class="mb-4">
                             <label for="amount" class="form-label fw-semibold">
                                 Amount <span class="text-danger">*</span>
                             </label>

                             <div class="input-group">
                                 <span class="input-group-text">Amount</span>
                                 <input
                                     type="number"
                                     name="amount"
                                     id="amount"
                                     class="form-control @error('amount') is-invalid @enderror"
                                     value="{{ old('amount') }}"
                                     min="0"
                                     step="0.01"
                                     placeholder="Enter payment amount"
                                     required>

                                 @error('amount')
                                 <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>

                             <div class="form-text">
                                 Enter the amount in the currency configured for your application.
                             </div>
                         </div>

                         {{-- Payment method --}}
                         <div class="mb-4">
                             <label for="method" class="form-label fw-semibold">
                                 Payment Method <span class="text-danger">*</span>
                             </label>

                             <select
                                 name="method"
                                 id="method"
                                 class="form-select @error('method') is-invalid @enderror"
                                 required>

                                 <option value="">Choose a payment method</option>

                                 <option value="card" {{ old('method') === 'card' ? 'selected' : '' }}>
                                     Card
                                 </option>

                                 <option value="cash" {{ old('method') === 'cash' ? 'selected' : '' }}>
                                     Cash
                                 </option>

                                 <option value="online" {{ old('method') === 'online' ? 'selected' : '' }}>
                                     Online
                                 </option>

                             </select>

                             @error('method')
                             <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>

                         <hr class="my-4">

                         <div class="d-flex flex-column flex-sm-row justify-content-end gap-2">
                             <a href="{{ route('payments.index') }}"
                                 class="btn btn-light border px-4">
                                 Cancel
                             </a>

                             <button type="submit" class="btn btn-primary px-4">
                                 Create Payment
                             </button>
                         </div>

                     </form>

                     @endif

                 </div>
             </div>
         </div>

         {{-- Information panel --}}
         <div class="col-12 col-xl-4">

             <div class="card border-0 shadow-sm mb-4">
                 <div class="card-body p-4">
                     <h6 class="fw-bold mb-3">Before You Continue</h6>

                     <div class="d-flex gap-3 mb-3">
                         <div>
                             <span class="badge bg-primary-subtle text-primary rounded-circle p-2">1</span>
                         </div>
                         <div>
                             <div class="fw-semibold">Choose an appointment</div>
                             <small class="text-muted">
                                 Select an appointment that does not already have a payment.
                             </small>
                         </div>
                     </div>

                     <div class="d-flex gap-3 mb-3">
                         <div>
                             <span class="badge bg-primary-subtle text-primary rounded-circle p-2">2</span>
                         </div>
                         <div>
                             <div class="fw-semibold">Enter payment details</div>
                             <small class="text-muted">
                                 Provide the amount and select the payment method.
                             </small>
                         </div>
                     </div>

                     <div class="d-flex gap-3">
                         <div>
                             <span class="badge bg-primary-subtle text-primary rounded-circle p-2">3</span>
                         </div>
                         <div>
                             <div class="fw-semibold">Review the payment</div>
                             <small class="text-muted">
                                 The payment record is initially created with pending status.
                             </small>
                         </div>
                     </div>
                 </div>
             </div>

             <div class="alert alert-info border-0 mb-0">
                 <h6 class="fw-semibold">Payment status</h6>
                 <p class="small mb-0">
                     Creating a payment record does not confirm that money has been received.
                     The current backend initializes new payments with pending status.
                 </p>
             </div>

         </div>

     </div>

 </div>

 @endsection