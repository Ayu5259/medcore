<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of prescriptions.
     */
    public function index()
    {
        Gate::authorize('viewAny', Prescription::class);

        //
    }

    /**
     * Show the form for creating a new prescription.
     */
    public function create()
    {
        Gate::authorize('create', Prescription::class);

        $doctor = Auth::user()?->doctor;

        if (!$doctor) {
            abort(403);
        }

        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDoesntHave('prescription')
            ->with('patient.user')
            ->get();

        $medicines = Medicine::orderBy('name')->get();

        return view(
            'prescriptions.create',
            compact('appointments', 'medicines')
        );
    }
    /**
     * Store a newly created prescription.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Prescription::class);

        $validated = $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],

            'items' => ['required', 'array', 'min:1'],

            'items.*.medicine_id' => [
                'required',
                'exists:medicines,id',
            ],

            'items.*.dosage' => [
                'required',
                'string',
            ],

            'items.*.duration' => [
                'required',
                'string',
            ],

            'items.*.frequency' => [
                'required',
                'string',
            ],

            'items.*.instructions' => [
                'nullable',
                'string',
            ],
        ]);

        $doctor = Auth::user()?->doctor;

        if (!$doctor) {
            abort(403);
        }

        $appointment = Appointment::where('id', $validated['appointment_id'])
            ->where('doctor_id', $doctor->id)
            ->firstOrFail();

        if ($appointment->prescription()->exists()) {
            abort(
                409,
                'A prescription already exists for this appointment.'
            );
        }

        $prescription = DB::transaction(function () use ($validated, $appointment) {

            $prescription = Prescription::create([
                'appointment_id' => $appointment->id,
            ]);

            foreach ($validated['items'] as $item) {
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $item['medicine_id'],
                    'dosage' => $item['dosage'],
                    'duration' => $item['duration'],
                    'frequency' => $item['frequency'],
                    'instructions' => $item['instructions'] ?? null,
                ]);
            }

            return $prescription;
        });

        return redirect()
            ->route('prescriptions.show', $prescription)
            ->with(
                'success',
                'Prescription created successfully.'
            );
    }

    /**
     * Display the specified prescription.
     */
    public function show(Prescription $prescription)
    {
        Gate::authorize('view', $prescription);

        $prescription->load([
            'appointment.doctor.user',
            'appointment.patient.user',
            'prescriptionItems.medicine',
        ]);

        return view(
            'prescriptions.show',
            compact('prescription')
        );
    }

    /**
     * Show the form for editing the specified prescription.
     */
    public function edit(Prescription $prescription)
    {
        Gate::authorize('update', $prescription);

        $prescription->load([
            'appointment.patient.user',
            'prescriptionItems.medicine',
        ]);

        $medicines = Medicine::orderBy('name')->get();

        return view(
            'prescriptions.edit',
            compact('prescription', 'medicines')
        );
    }
    /**
     * Update the specified prescription.
     */
    public function update(
        Request $request,
        Prescription $prescription
    ) {
        Gate::authorize('update', $prescription);

        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],

            'items.*.medicine_id' => [
                'required',
                'exists:medicines,id',
            ],

            'items.*.dosage' => [
                'required',
                'string',
            ],

            'items.*.duration' => [
                'required',
                'string',
            ],

            'items.*.frequency' => [
                'required',
                'string',
            ],

            'items.*.instructions' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use ($prescription, $validated) {

            $prescription->prescriptionItems()->delete();

            foreach ($validated['items'] as $item) {
                $prescription->prescriptionItems()->create([
                    'medicine_id' => $item['medicine_id'],
                    'dosage' => $item['dosage'],
                    'duration' => $item['duration'],
                    'frequency' => $item['frequency'],
                    'instructions' => $item['instructions'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('prescriptions.show', $prescription)
            ->with(
                'success',
                'Prescription updated successfully.'
            );
    }

    /**
     * Remove the specified prescription.
     */
    public function destroy(Prescription $prescription)
    {
        Gate::authorize('delete', $prescription);

        //
    }
}
