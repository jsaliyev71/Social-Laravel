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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('owner_user_id')->constrained('users')->restrictOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();

            $table->text('description')->nullable();

            $table->string('profile_pic')->nullable();
            $table->string('banner_img')->nullable();

            $table->string('visibility')->default('public');
            $table->string('posting_mode')->default('members');
            $table->string('commenting_mode')->default('members');

            $table->boolean('requires_join_approval')->default(false);

            $table->timestamps();
            
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
