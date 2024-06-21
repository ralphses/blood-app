<?php

namespace Database\Factories;

use App\Enums\AppointmentReason;
use App\Enums\Status\DonationAppointmentStatus;
use App\Models\Donation;
use App\Models\DonationAppointment;
use App\Models\DonationMatch;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationAppointment>
 */
class DonationAppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DonationAppointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'donation_match_id' => DonationMatch::factory(),
            'donation_id' => Donation::factory(),
            'appointment_date' => $this->faker->date(),
            'appointment_time' => $this->faker->time(),
            'location_id' => Location::factory(),
            'status' => $this->faker->randomElement(Arr::map(DonationAppointmentStatus::cases(), fn($role) => $role->name)),
        ];
    }
}
