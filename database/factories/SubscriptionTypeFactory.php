<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubscriptionType>
 */
class SubscriptionTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'benefits' => fake()->sentence(),
            'price' => rand(50, 1000),
            'duration' => rand(60, 525600),   // in minutes 1hr - 1yr
        ];
    }
}
