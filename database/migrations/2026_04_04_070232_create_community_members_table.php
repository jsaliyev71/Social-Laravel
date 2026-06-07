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
        Schema::create('community_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->string('color')->nullable();
            $table->string('community_pic')->nullable();
            $table->string('community_nickname')->nullable();
            $table->string('status')->default('pending');

            $table->boolean('is_muted')->default(false);
            $table->boolean('notify_new_posts')->default(true);
            $table->boolean('notify_announcements')->default(true);

            $table->timestamp('joined_at')->nullable();
            $table->timestamps();

            $table->unique(['community_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_members');
    }
};
