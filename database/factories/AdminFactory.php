<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),

            'email' => $this->faker->unique()->safeEmail(),

            'password' => bcrypt('123456789'),

            'role' => $this->faker->randomElement([
                Admin::ROLE_ADMIN,
                Admin::ROLE_SUPER_ADMIN,
            ]),

            'store_id' => null,

            'status' => Admin::STATUS_ACTIVE,

            'created_at' => now(),
        ];
    }
}