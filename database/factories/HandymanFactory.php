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
            'user_id' => User::factory(['role' => User::HANDYMAN]),
            'image_id' => null,
            'subscription_type_id' => null,
            'about' => fake()->paragraph(),
            'tools' => json_encode(['tool1' => fake()->word(), 'tool2' => fake()->word(), 'tool3' => fake()->word(), 'tool4' => fake()->word()]),
            'membership_level' => fake()->word(),
            'reputation_score' => rand(1, 10),
            'avg_rating' => rand(1, 5),
            'experience' => fake()->word(),
            'hire_count' => rand(1, 200),
            'group_type' => fake()->randomElement([Handyman::INDIVIDUAL, Handyman::GROUP]),
            'group_members' => json_encode([(User::factory()->create())->id, (User::factory()->create())->id, (User::factory()->create())->id, (User::factory()->create())->id]),
            'certifications' => json_encode(['1' => fake()->word(), '2' => fake()->word(), '3' => fake()->word(), '4' => fake()->word()]),
            'languages' => json_encode(['1' => 'english', '2' => 'amharic']),
            'contact' => json_encode(['phone' => '+251987654321', 'email' => 'email@domain.com']),
            'approval_status' => Handyman::APPROVED,
        ];
    }
}
