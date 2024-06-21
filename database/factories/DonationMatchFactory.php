<?php

namespace Database\Factories;

use App\Enums\Status\DonationMatchStatus;
use App\Models\DonationMatch;
use App\Models\User;
use App\Utils;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationMatch>
 */
class DonationMatchFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DonationMatch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'donor_id' => User::inRandomOrder()->first()->id,
            'recipient_id' => User::inRandomOrder()->first()->id,
            'blood_type' => $this->faker->randomElement(array_keys(Utils::BLOOD_TYPE)),
            'status' => $this->faker->randomElement(DonationMatchStatus::cases()),
        ];
    }
}
