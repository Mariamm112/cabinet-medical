<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('appointments', AppointmentController::class);
Route::get('/appointments/search', [AppointmentController::class, 'search'])
    ->name('appointments.search');