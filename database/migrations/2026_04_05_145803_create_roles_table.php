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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('creator_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('community_id')->nullable()->constrained('communities')->cascadeOnDelete();

            $table->string('name');

            $table->string('scope_type')->default('global');

            $table->timestamps();

            $table->softDeletes();

            $table->unique(['community_id', 'name', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
