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
        Schema::create('handymen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('featured_image_id')->index()->nullable();
            $table->foreignId('service_id')->index();
            $table->foreignId('category_id')->index();
            $table->string('about');
            $table->json('tools')->nullable();
            $table->string('membership_level')->nullable();
            $table->string('reputation_score')->nullable();
            $table->decimal('avg_rating', 2, 1)->default(0);
            $table->string('experience')->nullable();
            $table->string('hire_count')->default(0);
            $table->tinyInteger('group_type')->default(1);
            $table->json('group_members')->nullable();
            $table->json('certifications')->nullable();
            $table->json('languages')->nullable();
            $table->tinyInteger('approval_status')->default(1);
            $table->foreignId('subscription_type_id')->index();
            $table->timestamps();
            $table->timestamp('banned_at')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handymen');
    }
};