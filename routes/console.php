<?php

use App\Models\DonationAppointment;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {

    $location = DonationAppointment::findOrFail(10)->location;

    $location->latitude += mt_rand(-100, 100) / 100000; // Define generateIncrement() method
    $location->longitude += mt_rand(-100, 100) / 100000; // Define generateIncrement() method
    $location->save();
})->everySecond();

