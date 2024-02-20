<?php

use App\Models\SubscriptionType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('benefits');
            $table->string('price');
            $table->string('duration');
            $table->timestamps();
        });

        SubscriptionType::create([
            'name' => 'Free',
            'benefits' => fake()->sentence(),
            'price' => rand(50, 1000),
            'duration' => rand(60, 525600),
        ]);
        SubscriptionType::create([
            'name' => 'Featured',
            'benefits' => fake()->sentence(),
            'price' => rand(50, 1000),
            'duration' => rand(60, 525600),
        ]);
        SubscriptionType::create([
            'name' => 'Premium',
            'benefits' => fake()->sentence(),
            'price' => rand(50, 1000),
            'duration' => rand(60, 525600),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_types');
    }
};
