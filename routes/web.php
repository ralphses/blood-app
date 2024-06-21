<?php

use App\Http\Controllers\{DonationAppointmentController,
    DonationController,
    DonationMatchController,
    DonationRequestController,
    ProfileController,
    UserProfileController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::prefix('dashboards')->middleware('auth')->group(function () {

    Route::get('', [UserProfileController::class, 'dashboard'])->name('dashboard');

    Route::prefix('users')->group(function () {
        Route::get('', [UserProfileController::class, 'index'])->name('dashboard.users');
        Route::get('{userId}', [UserProfileController::class, 'show'])->name('dashboard.users.show');
        Route::get('role/{userId}', [UserProfileController::class, 'showRole'])->name('dashboard.users.role');
        Route::put('role/{userId}', [UserProfileController::class, 'storeRole'])->name('dashboard.users.role');
        Route::delete('{userId}', [UserProfileController::class, 'delete'])->name('dashboard.users.delete');
    });

    Route::prefix('appointments')->group(function () {
        Route::get('', [DonationAppointmentController::class, 'index'])->name('dashboard.appointments');
        Route::get('{appointment}', [DonationAppointmentController::class, 'edit'])->name('dashboard.appointments.modify');
        Route::post('{appointment}', [DonationAppointmentController::class, 'update'])->name('dashboard.appointments.modify');
        Route::post('book/{requestId}/{donation}', [DonationAppointmentController::class, 'book'])->name('dashboard.appointments.book');
        Route::get('book/{requestId}/{donation}', [DonationAppointmentController::class, 'book'])->name('dashboard.appointments.book');
        Route::post('/new/request', [DonationAppointmentController::class, 'requestAppointment'])->name('dashboard.appointments.request');
        Route::get('/{appointment}/track', [DonationAppointmentController::class, 'track'])->name('dashboard.appointments.track');
        Route::post('/{appointment}/location/update', [DonationAppointmentController::class, 'updateLocation'])->name('dashboard.appointments.update-location');
        Route::put('/{appointment}/completed', [DonationAppointmentController::class, 'markCompleted'])->name('dashboard.appointments.mark-complete');
    });

    Route::prefix('donations')->group(function () {

        Route::get('', [DonationController::class, 'index'])->name('dashboard.donations');
        Route::get('create', [DonationController::class, 'create'])->name('dashboard.donations.create');
        Route::post('create', [DonationController::class, 'store'])->name('dashboard.donations.create');
        Route::patch('cancel/{donationId}', [DonationController::class, 'cancel'])->name('dashboard.donations.cancel');

        Route::prefix('matches')->group(function () {
            Route::get('', [DonationMatchController::class, 'index'])->name('dashboard.donation.matches');
            Route::get('{matchId}', [DonationMatchController::class, 'show'])->name('dashboard.donation.matches.show');
            Route::post('cancel/{matchId}', [DonationMatchController::class, 'cancel'])->name('dashboard.donation.matches.cancel');
            Route::patch('{matchId}', [DonationMatchController::class, 'update'])->name('dashboard.donation.matches.update');
            Route::delete('{matchId}', [DonationMatchController::class, 'delete'])->name('dashboard.donation.matches.delete');
        });

        Route::prefix('requests')->group(function () {
            Route::get('', [DonationRequestController::class, 'index'])->name('dashboard.donations.requests');
            Route::get('/view/{requestId}', [DonationRequestController::class, 'show'])->name('dashboard.donations.requests.show');
            Route::get('/edit/{requestId}', [DonationRequestController::class, 'edit'])->name('dashboard.donations.requests.edit');
            Route::patch('/{requestId}', [DonationRequestController::class, 'update'])->name('dashboard.donations.requests.update');
            Route::delete('/{requestId}', [DonationRequestController::class, 'delete'])->name('dashboard.donations.requests.delete');
            Route::post('cancel/{requestId}', [DonationRequestController::class, 'cancel'])->name('dashboard.donations.requests.cancel');
            Route::get('create', [DonationRequestController::class, 'create'])->name('dashboard.donations.requests.create');
            Route::post('create', [DonationRequestController::class, 'store'])->name('dashboard.donations.requests.store');
            Route::get('/donations/{requestId?}', [DonationRequestController::class, 'getDonations'])->name('dashboard.donations.requests.donations');
        });
    });
});


Route::get('/appointments/{appointment}/location', [DonationAppointmentController::class, 'show'])
    ->name('api.appointments.location');

require __DIR__.'/auth.php';
