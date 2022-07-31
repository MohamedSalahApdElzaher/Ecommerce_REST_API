<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'details' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(100, 700),
            'stock' => $this->faker->randomDigit(),
            'discount' => $this->faker->numberBetween(2, 30)
        ];
    }
}
