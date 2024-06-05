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
            'login' => fake()->unique()->name(),
            'password' => 'mi@w.UwU', // password
            'email' => fake()->unique()->safeEmail(),
            'firstname' => fake()->name(),
            'lastname' => fake()->name(),
        ];
    }
}
