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
        Schema::create('handyman_service', function (Blueprint $table) {
            $table->foreignId('service_id')->index();
            $table->foreignId('handyman_id')->index();
            $table->timestamps();
            
            $table->unique(['service_id', 'handyman_id']);
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
