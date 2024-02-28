<?php

use App\Models\Service;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('hidden')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Service::create([
            'category_id' => 5,
            'title' => 'service_one',
            'description' => fake()->paragraph(),
        ]);
        Service::create([
            'category_id' => 4,
            'title' => 'service_two',
            'description' => fake()->paragraph(),
        ]);
        Service::create([
            'category_id' => 3,
            'title' => 'service_three',
            'description' => fake()->paragraph(),
        ]);
        Service::create([
            'category_id' => 2,
            'title' => 'service_four',
            'description' => fake()->paragraph(),
        ]);
        Service::create([
            'category_id' => 1,
            'title' => 'service_five',
            'description' => fake()->paragraph(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
