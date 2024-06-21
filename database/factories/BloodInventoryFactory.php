<?php

namespace Database\Factories;

use App\Models\BloodInventory;
use App\Utils;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BloodInventory>
 */
class BloodInventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BloodInventory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'blood_type' => $this->faker->randomElement(array_keys(Utils::BLOOD_TYPE)),
            'quantity' => $this->faker->numberBetween(1, 10),
            'collection_date' => $this->faker->date(),
            'expiry_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'location' => $this->faker->address,
        ];
    }
}
