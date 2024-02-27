<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Report;
use App\Models\Handyman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
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
            'reportable_id' => User::factory(),
            'reportable_type' => function (array $attributes) {
                return User::find($attributes['reportable_id'])->getMorphClass();
            },
            'reason' => fake()->paragraph(),
            'report_status' => fake()->randomElement([Report::REVIEWED, Report::NOT_REVIEWED]),
        ];
    }

    public function forHandyman(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'reportable_id' => Handyman::factory(),
                'reportable_type' => function (array $attributes) {
                    return Handyman::find($attributes['reportable_id'])->getMorphClass();
                },
            ];
        });
    }
}
