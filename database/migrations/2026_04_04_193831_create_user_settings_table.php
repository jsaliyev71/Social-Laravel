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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            
            $table->string('language')->default('en');
            $table->string('theme')->default('light');
            
            $table->boolean('is_notifications_muted')->default(false);
            $table->boolean('allow_message_requests')->default(true);

            $table->string('follow_mode')->default('public');
            $table->string('profile_visibility')->default('public');
            $table->string('post_visibility')->default('public');
            $table->string('comment_visibility')->default('public');

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
};
