<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Quote;
use App\Models\Handyman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
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
            'handyman_id' => Handyman::factory(),
            'quote_details' => fake()->sentence(),
            'price' => rand(11, 999999),
            'acceptance_status' => Quote::ACCEPTED,
        ];
    }
}
