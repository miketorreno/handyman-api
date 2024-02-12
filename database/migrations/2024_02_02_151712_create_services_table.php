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
            $table->foreignId('service_category_id')->index();
            $table->string('title');
            $table->string('description')->nullable();
            $table->boolean('hidden')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Service::create([
            'service_category_id' => 5,
            'title' => 'service_one',
            'description' => 'Ipsum minus deleniti et deserunt eveniet iure sint, sapiente magnam ducimus repellat veniam in.',
        ]);
        Service::create([
            'service_category_id' => 4,
            'title' => 'service_two',
            'description' => 'Perspiciatis rem incidunt illo, reprehenderit deserunt totam. Culpa, expedita eligendi.',
        ]);
        Service::create([
            'service_category_id' => 3,
            'title' => 'service_three',
            'description' => 'Voluptas repellat reprehenderit facere quas quia? Pariatur amet corrupti minima ipsa ipsam fugit natus quos.',
        ]);
        Service::create([
            'service_category_id' => 2,
            'title' => 'service_four',
            'description' => 'Eveniet vel eligendi eum aut eos fugiat ipsa illum ea facilis ullam illo delectus ratione eaque.',
        ]);
        Service::create([
            'service_category_id' => 1,
            'title' => 'service_five',
            'description' => 'Pariatur amet corrupti minima ipsa ipsam fugit natus quos.',
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
