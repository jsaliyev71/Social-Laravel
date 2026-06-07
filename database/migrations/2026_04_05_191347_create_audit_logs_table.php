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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('scope_type')->default('user');
            $table->unsignedBigInteger('scope_id')->nullable();

            $table->string('action_type');
            
            $table->string('target_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();

            $table->json('details')->nullable();
            
            $table->timestamp('created_at')->useCurrent();

            $table->index(['scope_type', 'scope_id']);
            $table->index(['target_type', 'target_id']);
            $table->index(['actor_user_id', 'action_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
