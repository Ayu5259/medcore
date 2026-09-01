<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\VisitReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VisitReportController extends Controller
{
    /**
     * Show the form for creating a visit report.
     */
    public function create(Appointment $appointment)
    {
        Gate::authorize('create', [VisitReport::class, $appointment]);

        return view('visit_reports.create', compact('appointment'));
    }

    /**
     * Store a newly created visit report.
     */
    public function store(Request $request, Appointment $appointment)
    {
        Gate::authorize('create', [VisitReport::class, $appointment]);

        $validated = $request->validate([
            'diagnosis' => ['nullable', 'string'],
            'symptoms' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'blood_pressure' => ['nullable', 'string'],
            'temperature' => ['nullable', 'numeric'],
            'heart_rate' => ['nullable', 'integer'],
        ]);

        $appointment->visitReport()->create($validated);

        return redirect()
            ->route('appointments.show', $appointment)
            ->with('success', 'Visit report created successfully.');
    }

    /**
     * Display the visit report.
     */
    public function show(VisitReport $visitReport)
    {
        Gate::authorize('view', $visitReport);

        return view('visit_reports.show', compact('visitReport'));
    }

    /**
     * Show the form for editing the visit report.
     */
    public function edit(VisitReport $visitReport)
    {
        Gate::authorize('update', $visitReport);

        return view('visit_reports.edit', compact('visitReport'));
    }

    /**
     * Update the visit report.
     */
    public function update(
        Request $request,
        VisitReport $visitReport
    ) {
        Gate::authorize('update', $visitReport);

        $validated = $request->validate([
            'diagnosis' => ['nullable', 'string'],
            'symptoms' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'blood_pressure' => ['nullable', 'string'],
            'temperature' => ['nullable', 'numeric'],
            'heart_rate' => ['nullable', 'integer'],
        ]);

        $visitReport->update($validated);

        return redirect()
            ->route('visit-reports.show', $visitReport)
            ->with('success', 'Visit report updated successfully.');
    }
}
