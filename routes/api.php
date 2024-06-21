<?php

use App\Http\Controllers\DonationAppointmentController;
use Illuminate\Support\Facades\Route;

Route::get('/appointments/{appointment}/location', [DonationAppointmentController::class, 'show'])
    ->name('api.appointments.location');
