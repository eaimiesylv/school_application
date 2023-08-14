<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'regno' => $this->faker->unique()->randomNumber(5),
            'session_id' => 13,
            'class_id' => $this->faker->numberBetween(7, 10),
            'arm_id' => null, // Set the appropriate value for the 'arm_id' column
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
            'session_class'=>'not set'
        ];
    }
}
