<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('yard_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->date('date');
            $table->json('items')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yard_sales');
    }
};
