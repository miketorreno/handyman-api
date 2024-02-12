<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Service;
use App\Models\Handyman;
use App\Models\ServiceCategory;
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
            'service_id' => Service::factory(),
            'category_id' => ServiceCategory::factory(),
            'subscription_type_id' => SubscriptionType::factory(),
            'about' => fake()->paragraph(),
            'tools' => fake()->paragraph(),
            'membership_level' => fake()->word(),
            'reputation_score' => rand(1, 10),
            'avg_rating' => rand(1, 10),
            'experience' => fake()->word(),
            'hire_count' => rand(1, 200),
            'group_type' => faker()->randomElement([Handyman::TYPE_INDIVIDUAL, Handyman::TYPE_GROUP]),
            'group_members' => fake()->paragraph(),
            'certifications' => fake()->paragraph(),
            'languages' => fake()->paragraph(),
            'approval_status' => faker()->randomElement([Handyman::APPROVAL_PENDING, Handyman::APPROVAL_APPROVED, Handyman::APPROVAL_REJECTED]),
        ];
    }
}
