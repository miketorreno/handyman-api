<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Handyman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'handyman_id' => Handyman::factory(),
            'user_id' => User::factory(),
            'rating' => rand(1, 5),
            'review' => fake()->paragraph(),
            'image_id' => null,
            'edited' => false,
            'requested' => false,
        ];
    }
}
