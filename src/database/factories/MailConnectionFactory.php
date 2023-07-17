<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\EncryptService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MailConnection>
 */
class MailConnectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'         => User::factory(),
            'email'           => fake()->unique()->safeEmail(),
            'cipher_password' => EncryptService::execEncrypt('password'),
            'mail_box'        => fake()->word(),
            'host'            => config('const.mail_connection.host'),
            'port'            => fake()->numberBetween(10, 10000),
            'subject'         => fake()->word(),
        ];
    }
}
