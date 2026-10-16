 @extends('layouts.app')

 @section('title', 'Medical Record')

 @section('content')
 <div class="container py-4 py-lg-5">

     {{-- Page header --}}
     <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
         <div>
             <div class="text-uppercase text-primary fw-semibold small mb-2">
                 Patient Management
             </div>

             <h1 class="h2 fw-bold text-dark mb-2">
                 Medical Record
             </h1>

             <p class="text-secondary mb-0">
                 Patient information and medical history
             </p>
         </div>

         <a href="{{ url()->previous() }}"
             class="btn btn-outline-secondary">
             Back
         </a>
     </div>

     {{-- Patient information --}}
     <div class="card border-0 shadow-sm rounded-4 mb-4">
         <div class="card-body p-4">
             <div class="d-flex align-items-center gap-3 mb-3">
                 <div class="rounded-circle bg-primary bg-opacity-10 text-primary
                            d-flex align-items-center justify-content-center
                            fw-bold"
                     style="width: 56px; height: 56px; font-size: 1.25rem;">
                     {{ strtoupper(substr($medicalRecord->patient->user->first_name, 0, 1)) }}
                 </div>

                 <div>
                     <h2 class="h5 fw-bold mb-1">
                         {{ $medicalRecord->patient->user->first_name }}
                         {{ $medicalRecord->patient->user->last_name }}
                     </h2>

                     <span class="text-secondary small">
                         Patient Medical Profile
                     </span>
                 </div>
             </div>

             <hr class="border-light">

             <div class="row g-3">
                 <div class="col-md-6">
                     <div class="bg-light rounded-3 p-3 h-100">
                         <div class="small text-secondary mb-1">
                             Record Number
                         </div>

                         <div class="fw-semibold">
                             #{{ $medicalRecord->id }}
                         </div>
                     </div>
                 </div>

                 <div class="col-md-6">
                     <div class="bg-light rounded-3 p-3 h-100">
                         <div class="small text-secondary mb-1">
                             Total Medical Entries
                         </div>

                         <div class="fw-semibold">
                             {{ $medicalRecord->entries->count() }}
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     {{-- Medical history heading --}}
     <div class="d-flex flex-wrap justify-content-between
                align-items-center gap-2 mb-3">
         <div>
             <h2 class="h4 fw-bold mb-1">
                 Medical History
             </h2>

             <p class="text-secondary small mb-0">
                 Diagnosis, treatment and clinical notes
             </p>
         </div>

         <span class="badge rounded-pill text-bg-primary px-3 py-2">
             {{ $medicalRecord->entries->count() }} Entries
         </span>
     </div>

     {{-- Medical history entries --}}
     @forelse ($medicalRecord->entries as $entry)

     <article class="card border-0 shadow-sm rounded-4 mb-3">
         <div class="card-body p-4">

             {{-- Entry header --}}
             <div class="d-flex flex-wrap justify-content-between
                            align-items-start gap-3 mb-4">
                 <div>
                     <div class="small text-secondary mb-1">
                         Diagnosis
                     </div>

                     <h3 class="h5 fw-bold mb-2">
                         {{ $entry->diagnosis }}
                     </h3>

                     <div class="small text-secondary">
                         Dr.
                         {{ $entry->doctor->user->first_name }}
                         {{ $entry->doctor->user->last_name }}
                     </div>
                 </div>

                 <span class="badge rounded-pill bg-light text-secondary
                                 border px-3 py-2">
                     {{ $entry->created_at->format('Y-m-d H:i') }}
                 </span>
             </div>

             {{-- Treatment --}}
             <div class="mb-3">
                 <h4 class="h6 fw-bold text-dark mb-2">
                     Treatment
                 </h4>

                 <div class="bg-light rounded-3 p-3 text-secondary">
                     {{ $entry->treatment ?: 'No treatment information available.' }}
                 </div>
             </div>

             {{-- Notes --}}
             <div class="mb-4">
                 <h4 class="h6 fw-bold text-dark mb-2">
                     Clinical Notes
                 </h4>

                 <div class="bg-light rounded-3 p-3 text-secondary">
                     {{ $entry->notes ?: 'No additional notes available.' }}
                 </div>
             </div>

             {{-- Actions --}}
             <div class="d-flex flex-wrap gap-2 pt-3 border-top">
                 <a href="{{ route('medical-record-entries.show', $entry) }}"
                     class="btn btn-primary btn-sm px-3">
                     View Entry
                 </a>

                 @can('update', $entry)
                 <a href="{{ route('medical-record-entries.edit', $entry) }}"
                     class="btn btn-outline-secondary btn-sm px-3">
                     Edit Entry
                 </a>
                 @endcan
             </div>

         </div>
     </article>

     @empty

     <div class="card border-0 shadow-sm rounded-4">
         <div class="card-body text-center py-5 px-4">
             <div class="text-secondary mb-3">
                 <span class="fs-1">—</span>
             </div>

             <h3 class="h5 fw-bold">
                 No Medical History Yet
             </h3>

             <p class="text-secondary mb-0">
                 There are currently no medical entries for this patient.
             </p>
         </div>
     </div>

     @endforelse

 </div>
 @endsection