<?php

namespace Database\Factories;

use App\Enums\Status\DonationRequestStatus;
use App\Enums\UrgencyLevel;
use App\Models\DonationRequest;
use App\Models\User;
use App\Utils;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Nette\Utils\Random;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationRequest>
 */
class DonationRequestFactory extends Factory
{
    protected $model = DonationRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'blood_type' => $this->faker->randomElement(array_keys(Utils::BLOOD_TYPE)),
            'code' => Str::upper(Random::generate()),
            'urgency_level' => $this->faker->randomElement(UrgencyLevel::cases()),
            'notes' => $this->faker->paragraph,
            'amount' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(DonationRequestStatus::cases()),
        ];
    }
}
