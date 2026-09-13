<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller
{
    /**
     * Display appointments for the authenticated patient.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Appointment::class);

        $patient = $request->user()->patient;

        if (!$patient) {
            abort(403, 'Authenticated user is not a patient.');
        }

        $appointments = $patient->appointments()
            ->with('doctor.user')
            ->latest('appointment_date')
            ->get();

        return view('appointments.index', compact('appointments'));
    }


    /**
     * Display the appointment creation form.
     */
    public function create(Request $request)
    {
        Gate::authorize('create', Appointment::class);

        $user = $request->user();

        // Patient selects a doctor.
        if ($user->patient) {
            $doctors = Doctor::with('user')->get();

            return view(
                'appointments.create',
                compact('doctors')
            );
        }

        // Doctor selects a patient they have treated before.
        if ($user->doctor) {
            $patients = Patient::query()
                ->whereHas('appointments', function ($query) use ($user) {
                    $query->where('doctor_id', $user->doctor->id);
                })
                ->with('user')
                ->distinct()
                ->get();

            return view(
                'appointments.create',
                compact('patients')
            );
        }

        abort(403, 'User does not have a valid Patient or Doctor profile.');
    }


    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        Gate::authorize('view', $appointment);

        $appointment->load([
            'doctor.user',
            'patient.user',
            'medicalRecord',
        ]);

        return view('appointments.show', compact('appointment'));
    }


    /**
     * Display the appointment edit form.
     */
    public function edit(Appointment $appointment)
    {
        Gate::authorize('update', $appointment);

        return view('appointments.edit', compact('appointment'));
    }


    /**
     * Update an existing appointment.
     */
    public function update(
        Request $request,
        Appointment $appointment
    ) {
        Gate::authorize('update', $appointment);

        $validated = $request->validate([
            'appointment_date' => ['required', 'date'],
            'appointment_start_time' => ['required', 'date_format:H:i'],
            'appointment_end_time' => ['required', 'date_format:H:i'],
            'room_number' => ['required', 'integer'],
            'visit_type' => [
                'required',
                'in:InPerson,Online,Emergency,FollowUp',
            ],
            'notes' => ['nullable', 'string'],
        ]);

        $appointment->update($validated);

        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }


    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Appointment::class);

        $user = $request->user();

        /*
         * Determine the actor and target patient.
         *
         * Patient:
         * - patient is always the authenticated patient.
         * - doctor_id comes from the request.
         *
         * Doctor:
         * - doctor is always the authenticated doctor.
         * - patient_id comes from the request.
         */
        if ($user->patient) {
            $patient = $user->patient;

            $validated = $request->validate([
                'doctor_id' => [
                    'required',
                    'exists:doctors,id',
                ],
                'appointment_date' => [
                    'required',
                    'date',
                ],
                'appointment_start_time' => [
                    'required',
                    'date_format:H:i',
                ],
                'appointment_end_time' => [
                    'required',
                    'date_format:H:i',
                ],
                'reason' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'visit_type' => [
                    'required',
                    'in:InPerson,Online,Emergency,FollowUp',
                ],
                'notes' => [
                    'nullable',
                    'string',
                ],
            ]);

            $doctorId = $validated['doctor_id'];

            // Patient is always authorized to create for themselves.
            Gate::authorize('createForPatient', [
                Appointment::class,
                $patient,
            ]);
        } elseif ($user->doctor) {
            $doctor = $user->doctor;

            $validated = $request->validate([
                'patient_id' => [
                    'required',
                    'exists:patients,id',
                ],
                'appointment_date' => [
                    'required',
                    'date',
                ],
                'appointment_start_time' => [
                    'required',
                    'date_format:H:i',
                ],
                'appointment_end_time' => [
                    'required',
                    'date_format:H:i',
                ],
                'reason' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'visit_type' => [
                    'required',
                    'in:InPerson,Online,Emergency,FollowUp',
                ],
                'notes' => [
                    'nullable',
                    'string',
                ],
            ]);

            $patient = Patient::findOrFail($validated['patient_id']);

            // Doctor must have an existing relationship with the patient.
            Gate::authorize('createForPatient', [
                Appointment::class,
                $patient,
            ]);

            // Doctor is always taken from the authenticated user.
            $doctorId = $doctor->id;
        } else {
            abort(
                403,
                'User does not have a valid Patient or Doctor profile.'
            );
        }

        /*
         * The Medical Record is always determined by the
         * selected Patient. It is never accepted from the request.
         */
        $medicalRecord = $patient->medicalRecord;

        if (!$medicalRecord) {
            abort(422, 'Patient does not have a medical record.');
        }

        // Business Rule 1:
        // Appointment start time must be before end time.
        if (
            $validated['appointment_start_time']
            >=
            $validated['appointment_end_time']
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_start_time' =>
                    'Appointment start time must be before the end time.',
                ]);
        }

        // Determine the day of the week for the requested date.
        $date = Carbon::parse($validated['appointment_date']);

        $days = [
            0 => 'یکشنبه',
            1 => 'دوشنبه',
            2 => 'سه‌شنبه',
            3 => 'چهارشنبه',
            4 => 'پنجشنبه',
            5 => 'جمعه',
            6 => 'شنبه',
        ];

        $dayOfWeek = $days[$date->dayOfWeek];

        // Business Rule 2:
        // The doctor must have a schedule covering the requested time.
        $hasSchedule = DoctorSchedule::query()
            ->where('doctor_id', $doctorId)
            ->where('day_of_week', $dayOfWeek)
            ->where(
                'start_time',
                '<=',
                $validated['appointment_start_time']
            )
            ->where(
                'end_time',
                '>=',
                $validated['appointment_end_time']
            )
            ->exists();

        if (!$hasSchedule) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_start_time' =>
                    'The doctor is not available at the selected time.',
                ]);
        }

        // Business Rule 3:
        // A doctor cannot have overlapping active appointments.
        $hasConflict = Appointment::query()
            ->where('doctor_id', $doctorId)
            ->where(
                'appointment_date',
                $validated['appointment_date']
            )
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($validated) {
                $query
                    ->where(
                        'appointment_start_time',
                        '<',
                        $validated['appointment_end_time']
                    )
                    ->where(
                        'appointment_end_time',
                        '>',
                        $validated['appointment_start_time']
                    );
            })
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'appointment_start_time' =>
                    'The selected time is not available for this doctor.',
                ]);
        }

        /*
         * Create the appointment.
         *
         * doctor_id, patient_id and medical_record_id
         * are controlled by the server.
         */
        $appointment = Appointment::create([
            'doctor_id' => $doctorId,
            'patient_id' => $patient->id,
            'medical_record_id' => $medicalRecord->id,
            'appointment_date' => $validated['appointment_date'],
            'appointment_start_time' =>
            $validated['appointment_start_time'],
            'appointment_end_time' =>
            $validated['appointment_end_time'],
            'reason' => $validated['reason'],
            'room_number' => 1,
            'status' => 'pending',
            'visit_type' => $validated['visit_type'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('appointments.show', $appointment);
    }


    /**
     * Cancel an appointment.
     */
    public function cancel(Appointment $appointment)
    {
        Gate::authorize('cancel', $appointment);

        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', 'Appointment cancelled successfully.');
    }
}
