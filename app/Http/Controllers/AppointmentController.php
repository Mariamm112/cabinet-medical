<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\mail\Mailable;
use App\Models\Appointment;
use App\Mail\AppointmentCreated;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    return view('appointments.index');
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
    Appointment::create([
        'user_id' => auth()->id(),
        'service_id' => $request->service_id,
        'appointment_date' => $request->appointment_date,
    ]);
      $user = auth()->user();
    Mail::to($user->email)->send(new AppointmentCreated($appointment));

    return redirect()->back();
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
        //
    }
    public function search(Request $request)
{
    $appointments = Appointment::where('status', 'like', "%{$request->q}%")->get();

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
