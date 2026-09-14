<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class PaymentController extends Controller
{
    /**
     * Display payments accessible to the current user.
     */
    public function index()
    {
        Gate::authorize('viewAny', Payment::class);

        $user = Auth::user();
        $role = strtolower(trim($user->role?->name ?? ''));

        if ($role === 'patient') {
            $patient = $user->patient;

            if (!$patient) {
                abort(403);
            }

            $payments = Payment::where('patient_id', $patient->id)
                ->with([
                    'appointment.doctor.user',
                ])
                ->latest()
                ->get();
        } elseif ($role === 'doctor') {
            $doctor = $user->doctor;

            if (!$doctor) {
                abort(403);
            }

            $payments = Payment::whereHas('appointment', function ($query) use ($doctor) {
                $query->where('doctor_id', $doctor->id);
            })
                ->with([
                    'patient.user',
                    'appointment',
                ])
                ->latest()
                ->get();
        } else {
            $payments = collect();
        }

        return view(
            'payments.index',
            compact('payments')
        );
    }

    /**
     * Show appointments that the current patient can pay for.
     */
    public function create()
    {
        Gate::authorize('create', Payment::class);

        $patient = Auth::user()?->patient;

        if (!$patient) {
            abort(403);
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->whereDoesntHave('payment')
            ->with('doctor.user')
            ->latest('appointment_date')
            ->get();

        return view(
            'payments.create',
            compact('appointments')
        );
    }

    /**
     * Create a payment for the patient's own appointment.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Payment::class);

        $validated = $request->validate([
            'appointment_id' => [
                'required',
                'exists:appointments,id',
            ],
        ]);

        $patient = Auth::user()?->patient;

        if (!$patient) {
            abort(403);
        }

        $appointment = Appointment::with('doctor')
            ->where('id', $validated['appointment_id'])
            ->where('patient_id', $patient->id)
            ->firstOrFail();

        if ($appointment->payment()->exists()) {
            abort(
                409,
                'A payment already exists for this appointment.'
            );
        }

        $doctor = $appointment->doctor;

        if (!$doctor) {
            abort(
                422,
                'This appointment has no assigned doctor.'
            );
        }

        $payment = DB::transaction(function () use (
            $appointment,
            $patient,
            $doctor
        ) {
            return Payment::create([
                'patient_id' => $patient->id,
                'appointment_id' => $appointment->id,
                'amount' => $doctor->consultation_fee,
                'method' => 'card',
                'status' => 'pending',
            ]);
        });

        return redirect()
            ->route('payments.show', $payment)
            ->with(
                'success',
                'Payment created successfully.'
            );
    }

    /**
     * Display a specific payment.
     */
    public function show(Payment $payment)
    {
        Gate::authorize('view', $payment);

        $payment->load([
            'patient.user',
            'appointment.doctor.user',
        ]);

        return view(
            'payments.show',
            compact('payment')
        );
    }

    /**
     * Payments cannot be updated.
     */
    public function update(
        Request $request,
        Payment $payment
    ) {
        Gate::authorize('update', $payment);

        abort(403);
    }

    /**
     * Payments cannot be deleted.
     */
    public function destroy(Payment $payment)
    {
        Gate::authorize('delete', $payment);

        abort(403);
    }
}
