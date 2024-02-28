<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use App\Models\Handyman;
use App\Models\SubscriptionType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Handyman>
 */
class HandymanFactory extends Factory
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
            'image_id' => null,
            'subscription_type_id' => SubscriptionType::factory(),
            'about' => fake()->paragraph(),
            // 'tools' => fake()->paragraph(),  // * json()
            'membership_level' => fake()->word(),
            'reputation_score' => rand(1, 10),
            'avg_rating' => rand(1, 5),
            'experience' => fake()->word(),
            'hire_count' => rand(1, 200),
            'group_type' => fake()->randomElement([Handyman::INDIVIDUAL, Handyman::GROUP]),
            // 'group_members' => fake()->paragraph(),  // * json()
            // 'certifications' => fake()->paragraph(), // * json()
            // 'languages' => '{"0": "english", "1": "amharic"}',  // * json()
            'languages' => json_encode('{"languages": [{ "lang":"english"},{"lang":"amharic"}]}'),  // * json()
            'approval_status' => Handyman::APPROVED,
        ];
    }
}
