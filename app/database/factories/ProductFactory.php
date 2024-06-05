<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->unique()->word(),
            'description' => fake()->text(),
            'photo' => fake()->imageUrl(640, 480, 'cats', true),
            'price' => fake()->randomFloat(2, 1, 300),
        ];
    }
}
