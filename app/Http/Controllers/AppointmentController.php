<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Display the specified appointment.
    public function show(Appointment $appointment)
    {
        //$this->authorize('view', $appointment);
        Gate::authorize('view', $appointment);


        return "Appointment #{$appointment->id}";
    }
}
