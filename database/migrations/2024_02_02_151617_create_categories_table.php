<?php

use App\Models\Category;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('category');
            $table->string('description')->nullable();
            $table->boolean('hidden')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Category::create([
            'category' => 'category_one',
            'description' => fake()->paragraph(),
        ]);
        Category::create([
            'category' => 'category_two',
            'description' => fake()->paragraph(),
        ]);
        Category::create([
            'category' => 'category_three',
            'description' => fake()->paragraph(),
        ]);
        Category::create([
            'category' => 'category_four',
            'description' => fake()->paragraph(),
        ]);
        Category::create([
            'category' => 'category_five',
            'description' => fake()->paragraph(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
