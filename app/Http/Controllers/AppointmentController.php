<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Service;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        $appointments = Appointment::with('service')->latest()->paginate(10);
        return view('appointments.index', compact('appointments', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email|max:255',
            'patient_phone' => 'nullable|string|max:20',
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        $appointment = Appointment::create([
            'user_id' => auth()->id(),
            'service_id' => $validated['service_id'],
            'patient_name' => $validated['patient_name'],
            'patient_email' => $validated['patient_email'],
            'patient_phone' => $validated['patient_phone'] ?? null,
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', __('messages.appointment_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect()->back()->with('success', __('messages.appointment_deleted'));
    }

    /**
     * Search appointments with AJAX.
     */
    public function search(Request $request)
    {
        $query = Appointment::with('service');

        if ($request->has('q') && $request->q) {
            $query->where(function($q) use ($request) {
                $q->where('patient_name', 'like', "%{$request->q}%")
                  ->orWhere('patient_email', 'like', "%{$request->q}%");
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('appointment_date', $request->date);
        }

        $appointments = $query->latest()->take(10)->get();

        return view('appointments.partials.results', compact('appointments'))->render();
    }

public function apiIndex()
{
    return response()->json(Appointment::all());
}

public function apiStore(Request $request)
{
    return Appointment::create($request->all());
}

}