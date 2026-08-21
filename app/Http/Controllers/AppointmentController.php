<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Display the authenticated patients appointments.
    public function index(Request $request)
    {
        // Check whether the authenticated user is allowed
        // to view a list of appointments.
        Gate::authorize('viewAny', Appointment::class);

        // Get the Patient profile that belongs to the authenticated User.
        $patient = $request->user()->patient;

        // Make sure the authenticated user actually has a Patient profile.
        if (!$patient) {
            abort(403, 'Authenticated user is not a patient.');
        }

        // Retrieve only the appointments that belong to this Patient.
        // Doctor and Doctor's User are loaded for displaying the doctor's name.
        $appointments = $patient->appointments()
            ->with('doctor.user')
            ->latest('appointment_date')
            ->get();

        // Pass the appointments to the index view.
        return view('appointments.index', compact('appointments'));
    }


    // Display the appointment creation form.
    public function create()
    {
        // Check whether the authenticated user is allowed
        // to create a new appointment.
        Gate::authorize('create', Appointment::class);

        // Retrieve all doctors together with their related user.
        // The User model contains the doctor's first and last name.
        $doctors = Doctor::with('user')->get();

        // Pass the doctors collection to the appointment creation view.
        return view('appointments.create', compact('doctors'));
    }


    // Display the specified appointment.
    public function show(Appointment $appointment)
    {
        // Check whether the authenticated user is allowed
        // to view this specific appointment.
        Gate::authorize('view', $appointment);

        // Load the relationships needed by the appointment details page.
        // Doctor's name comes from the related User model.
        $appointment->load([
            'doctor.user',
            'patient.user',
            'medicalRecord',
        ]);

        // Pass the appointment data to the show view.
        return view('appointments.show', compact('appointment'));
    }


    // Display the appointment edit form.
    public function edit(Appointment $appointment)
    {
        // Check whether the authenticated user is allowed
        // to update this specific appointment.
        Gate::authorize('update', $appointment);

        // Pass the appointment to the edit view.
        return view('appointments.edit', compact('appointment'));
    }

    // Update an existing appointment.
    public function update(Request $request, Appointment $appointment)
    {
        // Check whether the authenticated user is allowed
        // to update this specific appointment.
        Gate::authorize('update', $appointment);

        // Validate only the fields that are allowed to be updated.
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

        // Update only the allowed appointment fields.
        $appointment->update($validated);

        // Redirect back to the appointment details page.
        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    // Store a newly created appointment.
    public function store(Request $request)
    {
        // Check whether the authenticated user is allowed
        // to create a new appointment.
        Gate::authorize('create', Appointment::class);

        // Get the Patient record that belongs to the authenticated User.
        // We do NOT accept patient_id from the request.
        $patient = $request->user()->patient;

        // Make sure the authenticated user actually has a Patient profile.
        if (!$patient) {
            abort(403, 'Authenticated user is not a patient.');
        }

        // Get the Medical Record that belongs to this Patient.
        // We do NOT accept medical_record_id from the request.
        $medicalRecord = $patient->medicalRecord;

        // Make sure the Patient has a Medical Record.
        if (!$medicalRecord) {
            abort(422, 'Patient does not have a medical record.');
        }

        // Validate only the data that the Patient is allowed to submit.
        $validated = $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_start_time' => ['required', 'date_format:H:i'],
            'appointment_end_time' => ['required', 'date_format:H:i'],
            'reason' => ['required', 'string', 'max:255'],
            'visit_type' => [
                'required',
                'in:InPerson,Online,Emergency,FollowUp',
            ],
            'notes' => ['nullable', 'string'],
        ]);

        // Create the Appointment using the authenticated Patient
        // and the Patient's Medical Record.
        $appointment = Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => $patient->id,
            'medical_record_id' => $medicalRecord->id,
            'appointment_date' => $validated['appointment_date'],
            'appointment_start_time' => $validated['appointment_start_time'],
            'appointment_end_time' => $validated['appointment_end_time'],
            'reason' => $validated['reason'],
            'room_number' => 1,
            'status' => 'pending',
            'visit_type' => $validated['visit_type'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Redirect the user to the newly created appointment.
        return redirect()->route('appointments.show', $appointment);
    }

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
