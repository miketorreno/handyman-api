<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
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
            'title' => fake()->word(),
            'description' => fake()->sentence(),
            'location' => fake()->address(),
            'date_and_time' => date('Y-m-d H:i:s'),
            'event_type' => fake()->randomElement([Event::VIRTUAL, Event::IN_PERSON]),
        ];
    }
}
