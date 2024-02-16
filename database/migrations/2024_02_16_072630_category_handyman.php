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
        Schema::create('category_handyman', function (Blueprint $table) {
            $table->foreignId('category_id')->index();
            $table->foreignId('handyman_id')->index();
            $table->timestamps();
            
            $table->unique(['category_id', 'handyman_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
