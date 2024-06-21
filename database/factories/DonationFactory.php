<?php

namespace Database\Factories;

use App\Enums\Status\DonationStatus;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(1, 10),
            'code' => Str::upper(Random::generate()),
            'blood_type' => $this->faker->bloodType(),
            'status' => $this->faker->randomElement(DonationStatus::cases()),
        ];
    }
}
