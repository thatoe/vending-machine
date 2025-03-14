<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // Random product name
            'price' => $this->faker->randomFloat(2, 0.5, 10), // Price between 0.5 and 10
            'quantity_available' => $this->faker->numberBetween(1, 100), // Stock between 1 and 100
        ];
    }
}