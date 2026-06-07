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
        Schema::create('user_relationships', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('related_user_id')->constrained('users')->cascadeOnDelete();

            $table->boolean('is_blocked')->default(false);
            $table->boolean('is_muted')->default(false);
            $table->boolean('is_hidden')->default(false);

            $table->timestamp('blocked_at')->nullable();
            $table->timestamp('muted_at')->nullable();
            $table->timestamp('hidden_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'related_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_relationships');
    }
};
