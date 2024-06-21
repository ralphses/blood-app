<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\BloodInventory;
use App\Models\Donation;
use App\Models\DonationAppointment;
use App\Models\DonationMatch;
use App\Models\DonationRequest;
use App\Models\DonationTracking;
use App\Models\Location;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $recipientLocation = Location::create([
            'latitude' => 8.502797289316952,
            'longitude' => 8.527367738261207,
            'address' => 'Dalhatu Araf Specialist Hospital'
        ]);

        User::create([
            'name' => 'Ralph',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => Role::ADMIN,
            'blood_type' => 'AB+',
            'phone' => '09876767676',
            'location_id' => $recipientLocation->id
        ]);

        $donorLocation = Location::create([
            'latitude' => 8.521683981884562,
            'longitude' => 8.531766857068853,
            'address' => 'Lafia Township Stadium'
        ]);

        User::create([
            'name' => 'Donor',
            'email' => 'donor@gmail.com',
            'password' => Hash::make('password'),
            'role' => Role::DONOR,
            'blood_type' => 'O+',
            'phone' => '09876767676',
            'location_id' => $donorLocation->id
        ]);

        User::create([
            'name' => 'Recipient',
            'email' => 'recipient@gmail.com',
            'password' => Hash::make('password'),
            'role' => Role::RECIPIENT,
            'blood_type' => 'A+',
            'phone' => '09876767676',
            'location_id' => $recipientLocation->id

        ]);
        UserProfile::factory(5)->create();
        Donation::factory(10)->create();
        BloodInventory::factory(3)->create();
        DonationTracking::factory(5)->create();
        DonationMatch::factory(10)->create();
        DonationAppointment::factory(5)->create();
        DonationRequest::factory(6)->create();
    }
}
