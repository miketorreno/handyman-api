<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YardSale>
 */
class YardSaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'location' => fake()->address(),
            'date' => date('Y-m-d'),
            'items' => json_encode(["item1" => fake()->word(), "item2" => fake()->word(), "item3" => fake()->word()]),
        ];
    }
}
