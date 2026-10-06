<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class DoctorScheduleController extends Controller
{
    /**
     * Display schedules and appointments.
     */
    public function index()
    {
        Gate::authorize('viewAny', DoctorSchedule::class);

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Doctor
        |--------------------------------------------------------------------------
        | Doctor sees:
        | - Their own weekly schedule
        | - Their own appointments
        | - Patient name for each appointment
        */
        if ($user->doctor) {

            $schedules = DoctorSchedule::with('doctor.user')
                ->where('doctor_id', $user->doctor->id)
                ->orderByRaw("
                    CASE day_of_week
                        WHEN 'شنبه' THEN 1
                        WHEN 'یکشنبه' THEN 2
                        WHEN 'دوشنبه' THEN 3
                        WHEN 'سه‌شنبه' THEN 4
                        WHEN 'چهارشنبه' THEN 5
                        WHEN 'پنجشنبه' THEN 6
                        WHEN 'جمعه' THEN 7
                    END
                ")
                ->orderBy('start_time')
                ->get();

            $appointments = Appointment::with([
                'patient.user',
            ])
                ->where('doctor_id', $user->doctor->id)
                ->orderBy('appointment_date')
                ->orderBy('appointment_start_time')
                ->get();
        } else {

            /*
            |--------------------------------------------------------------------------
            | Patient
            |--------------------------------------------------------------------------
            | Patient can see doctors' schedules,
            | but only their own appointments.
            */
            $schedules = DoctorSchedule::with([
                'doctor.user',
                'doctor.specialty',
            ])
                ->orderByRaw("
                    CASE day_of_week
                        WHEN 'شنبه' THEN 1
                        WHEN 'یکشنبه' THEN 2
                        WHEN 'دوشنبه' THEN 3
                        WHEN 'سه‌شنبه' THEN 4
                        WHEN 'چهارشنبه' THEN 5
                        WHEN 'پنجشنبه' THEN 6
                        WHEN 'جمعه' THEN 7
                    END
                ")
                ->orderBy('start_time')
                ->get();

            $appointments = Appointment::with([
                'doctor.user',
            ])
                ->where('patient_id', $user->patient->id)
                ->orderBy('appointment_date')
                ->orderBy('appointment_start_time')
                ->get();
        }

        return view('doctor_schedules.index', compact(
            'schedules',
            'appointments'
        ));
    }

    /**
     * Show the form for creating a schedule.
     */
    public function create()
    {
        Gate::authorize('create', DoctorSchedule::class);

        $daysOfWeek = [
            'شنبه',
            'یکشنبه',
            'دوشنبه',
            'سه‌شنبه',
            'چهارشنبه',
            'پنجشنبه',
            'جمعه',
        ];

        return view('doctor_schedules.create', compact('daysOfWeek'));
    }

    /**
     * Store a newly created schedule.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', DoctorSchedule::class);

        $validated = $request->validate([
            'day_of_week' => [
                'required',
                'in:شنبه,یکشنبه,دوشنبه,سه‌شنبه,چهارشنبه,پنجشنبه,جمعه',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
        ]);

        $doctor = $request->user()->doctor;

        DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        return redirect()
            ->route('doctor-schedules.index')
            ->with('success', 'Schedule added successfully.');
    }

    /**
     * Show the form for editing a schedule.
     */
    public function edit(DoctorSchedule $doctorSchedule)
    {
        Gate::authorize('update', $doctorSchedule);

        $daysOfWeek = [
            'شنبه',
            'یکشنبه',
            'دوشنبه',
            'سه‌شنبه',
            'چهارشنبه',
            'پنجشنبه',
            'جمعه',
        ];

        return view(
            'doctor_schedules.edit',
            compact('doctorSchedule', 'daysOfWeek')
        );
    }

    /**
     * Update the specified schedule.
     */
    public function update(
        Request $request,
        DoctorSchedule $doctorSchedule
    ) {
        Gate::authorize('update', $doctorSchedule);

        $validated = $request->validate([
            'day_of_week' => [
                'required',
                'in:شنبه,یکشنبه,دوشنبه,سه‌شنبه,چهارشنبه,پنجشنبه,جمعه',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
        ]);

        $doctorSchedule->update([
            'day_of_week' => $validated['day_of_week'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        return redirect()
            ->route('doctor-schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy(DoctorSchedule $doctorSchedule)
    {
        Gate::authorize('delete', $doctorSchedule);

        $doctorSchedule->delete();

        return redirect()
            ->route('doctor-schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}
