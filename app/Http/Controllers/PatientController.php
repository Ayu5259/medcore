<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
//PatientController@index ---> Patient records ---> User information ---> patients.index
class PatientController extends Controller
{
    /**
     * Display a listing of patients.
     */
    public function index(Request $request)
    {
        $patients = Patient::with('user')
            ->latest()
            ->paginate(10);

        return view('patients.index', compact('patients'));
    }
}
