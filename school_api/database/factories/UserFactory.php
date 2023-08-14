<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'sex' => $this->faker->randomElement(['M', 'F']),
            'dob' => $this->faker->date,
            'passport' => 'https://source.unsplash.com/random',
            'username' => $this->faker->userName,
            //'class_id' => $this->faker->numberBetween(1, 6),
            'session_id' => 13,
            'role' => $this->faker->randomElement([0, 1]),// Change this to the appropriate role value
            'status' => 'active',
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // Replace 'password' with your desired default password
            'ip' => $this->faker->ipv4,
            'hash' => Str::random(20),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
