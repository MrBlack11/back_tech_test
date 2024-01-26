<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            "brand" => fake()->text(10),
            "model" => fake()->text(20),
            "year" => now()->year,
            "renavam" => fake()->text(11),
            "plate" => fake()->text(10),
            "color" => fake()->text(20)
        ];
    }
}
