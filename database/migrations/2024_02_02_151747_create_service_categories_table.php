<?php

use App\Models\ServiceCategory;
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
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('category');
            $table->string('description')->nullable();
            $table->boolean('hidden')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        ServiceCategory::create([
            'category' => 'category_one',
            'description' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit.',
        ]);
        ServiceCategory::create([
            'category' => 'category_two',
            'description' => 'Sint placeat rem sed molestiae ullam eius vero voluptate atque.',
        ]);
        ServiceCategory::create([
            'category' => 'category_three',
            'description' => 'deserunt pariatur necessitatibus recusandae accusantium ipsa velit quos maxime quam possimus nemo.',
        ]);
        ServiceCategory::create([
            'category' => 'category_four',
            'description' => 'Consequatur, voluptatem porro quisquam esse quos et expedita sequi mollitia quod at.',
        ]);
        ServiceCategory::create([
            'category' => 'category_five',
            'description' => 'Minima eum incidunt omnis nihil. Sunt suscipit beatae numquam ut mollitia eligendi obcaecati eius..',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
