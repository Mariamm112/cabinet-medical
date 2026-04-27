<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    $totalAppointments = \App\Models\Appointment::count();
    $pendingAppointments = \App\Models\Appointment::where('status', 'pending')->count();
    $confirmedAppointments = \App\Models\Appointment::where('status', 'confirmed')->count();
    $recentAppointments = \App\Models\Appointment::with('service')->latest()->take(5)->get();
    
    return view('dashboard', compact('totalAppointments', 'pendingAppointments', 'confirmedAppointments', 'recentAppointments'));
})->name('dashboard');

// Appointments
Route::resource('appointments', AppointmentController::class);
Route::get('/appointments/search', [AppointmentController::class, 'search'])
    ->name('appointments.search');

// Services
Route::resource('services', ServiceController::class);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');