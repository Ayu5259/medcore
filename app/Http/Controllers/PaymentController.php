<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a list of payments available to the authenticated user.
     */
    public function index()
    {
        Gate::authorize('viewAny', Payment::class);

        $user = Auth::user();

        $role = strtolower(
            trim($user->role?->name ?? '')
        );


        $query = Payment::with([
            'patient.user',
            'appointment.doctor.user',
        ]);


        if ($role === 'patient') {

            if (!$user->patient) {
                abort(403, 'Authenticated user is not a patient.');
            }


            $query->where(
                'patient_id',
                $user->patient->id
            );
        } elseif ($role === 'doctor') {

            if (!$user->doctor) {
                abort(403, 'Authenticated user is not a doctor.');
            }


            $query->whereHas(
                'appointment',
                function ($q) use ($user) {

                    $q->where(
                        'doctor_id',
                        $user->doctor->id
                    );
                }
            );
        }



        $payments = $query
            ->latest()
            ->get();



        return view(
            'payments.index',
            compact('payments')
        );
    }




    /**
     * Show payment creation form.
     */
    public function create()
    {
        Gate::authorize('create', Payment::class);


        $patient = Auth::user()?->patient;


        if (!$patient) {
            abort(403);
        }


        $appointments = Appointment::with(
            'doctor.user'
        )
            ->where(
                'patient_id',
                $patient->id
            )
            ->whereDoesntHave('payment')
            ->latest('appointment_date')
            ->get();



        return view(
            'payments.create',
            compact('appointments')
        );
    }




    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Payment::class);


        $validated = $request->validate([

            'appointment_id' => [
                'required',
                'integer',
                'exists:appointments,id',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'method' => [
                'required',
                'in:cash,card,online',
            ],

        ]);



        $appointment = Appointment::findOrFail(
            $validated['appointment_id']
        );



        Gate::authorize(
            'createForAppointment',
            [$appointment]
        );



        if ($appointment->payment()->exists()) {

            return back()
                ->withErrors([
                    'appointment_id' =>
                    'This appointment already has a payment.',
                ])
                ->withInput();
        }




        $payment = DB::transaction(function () use (
            $appointment,
            $validated
        ) {

            return Payment::create([

                'patient_id' =>
                $appointment->patient_id,

                'appointment_id' =>
                $appointment->id,

                'amount' =>
                $validated['amount'],

                'method' =>
                $validated['method'],

                'status' =>
                'pending',

                'transaction_code' =>
                (string) random_int(
                    1000000000,
                    9999999999
                ),

            ]);
        });




        return redirect()

            ->route(
                'payments.show',
                $payment
            )

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
        Gate::authorize(
            'view',
            $payment
        );


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
     * Show payment edit form.
     */
    public function edit(Payment $payment)
    {
        Gate::authorize(
            'update',
            $payment
        );


        return view(
            'payments.edit',
            compact('payment')
        );
    }





    /**
     * Update payment.
     */
    public function update(
        Request $request,
        Payment $payment
    ) {

        Gate::authorize(
            'update',
            $payment
        );



        $validated = $request->validate([

            'status' => [
                'required',
                'in:pending,paid,failed,refunded',
            ],

            'method' => [
                'required',
                'in:cash,card,online',
            ],

        ]);



        $payment->update([

            'status' =>
            $validated['status'],

            'method' =>
            $validated['method'],

            'paid_at' =>
            $validated['status'] === 'paid'
                ? now()
                : null,

        ]);



        return redirect()

            ->route(
                'payments.show',
                $payment
            )

            ->with(
                'success',
                'Payment updated successfully.'
            );
    }





    /**
     * Delete payment.
     */
    public function destroy(Payment $payment)
    {
        Gate::authorize(
            'delete',
            $payment
        );


        abort(403);
    }
    /**
     * Display payment history for the authenticated doctor.
     */
    public function history()
    {
        Gate::authorize('viewAny', Payment::class);

        $user = Auth::user();

        $role = strtolower(
            trim($user->role?->name ?? '')
        );

        if ($role !== 'doctor') {
            abort(403);
        }

        if (!$user->doctor) {
            abort(403, 'Authenticated user is not a doctor.');
        }

        $payments = Payment::with([
            'patient.user',
            'appointment.doctor.user',
        ])
            ->whereHas('appointment', function ($query) use ($user) {
                $query->where(
                    'doctor_id',
                    $user->doctor->id
                );
            })
            ->latest()
            ->get();


        return view(
            'payments.history',
            compact('payments')
        );
        // return 'Bego bekhoda is working';
    }
}
