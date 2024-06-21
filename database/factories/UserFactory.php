<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\Location;
use App\Models\User;
use App\Utils;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'), // Default password, should be hashed
            'role' => $this->faker->randomElement(Arr::map(Role::cases(), fn($role) => $role->name)),
            'blood_type' => $this->faker->randomElement(array_keys(Utils::BLOOD_TYPE)),
            'phone' => $this->faker->phoneNumber,
            'location_id' => Location::factory(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the user is a donor.
     *
     * @return Factory
     */
    public function donor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'donor',
            ];
        });
    }

    /**
     * Indicate that the user is a recipient.
     *
     * @return Factory
     */
    public function recipient(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'recipient',
            ];
        });
    }

    /**
     * Indicate that the user is an admin.
     *
     * @return Factory
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
                'blood_type' => null,
                'phone' => null,
                'address' => null,
            ];
        });
    }
}
