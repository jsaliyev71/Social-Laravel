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
        Schema::create('dev_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('actor_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('log_level')->default('info');

            $table->string('action_type')->nullable();

            $table->string('http_method')->nullable();
            $table->unsignedSmallInteger('http_status')->nullable();

            $table->text('http_path')->nullable();
            $table->text('exception')->nullable();
            $table->text('user_agent')->nullable();

            $table->ipAddress('ip_address')->nullable();

            $table->json('details')->nullable();
            
            $table->timestamp('created_at')->useCurrent();

            $table->index('log_level');
            $table->index('actor_user_id');
            $table->index(['http_method', 'http_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dev_logs');
    }
};
