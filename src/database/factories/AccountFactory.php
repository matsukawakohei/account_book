<?php

namespace Database\Factories;

use App\Enums\StoreType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'name'       => fake()->word(),
            'amount'     => fake()->numberBetween(1000, 10000),
            'date'       => fake()->date(),
            'store_type' => StoreType::Manual,
        ];
    }
}
