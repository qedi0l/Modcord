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
    public function definition()
    {
        return [
            'uuid'=> fake()->uuid(),
            'text' => fake()->sentence(),
            'state' => fake()->word(),
            'ip_address' => fake()->ipv4(),
            'contacts' => fake()->words(), 
            'response' => fake()->sentence(),
        ];
    }
}