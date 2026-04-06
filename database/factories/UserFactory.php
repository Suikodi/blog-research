<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Pre-hashed password for dummy data
     */
    private static string $hashedPassword = '$2y$12$dXJ3SW6G7P50eS3MqsCae.ixVD6J7wbZAW4L.9XzbTc6MYHKhfDmu'; // hashed 'password'

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 0;
        $counter++;

        return [
            'name' => fake()->name(),
            'email' => 'user' . $counter . '@example.com',
            'email_verified_at' => now(),
            'password' => self::$hashedPassword,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
