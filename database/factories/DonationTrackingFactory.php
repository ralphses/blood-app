<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\DonationTracking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationTracking>
 */
class DonationTrackingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DonationTracking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'donation_id' => Donation::factory(),
            'current_location' => $this->faker->address,
            'timestamp' => $this->faker->dateTime,
            'status_description' => $this->faker->sentence,
        ];
    }
}
