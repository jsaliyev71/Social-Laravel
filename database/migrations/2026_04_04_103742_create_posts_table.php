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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('community_id')->nullable()->constrained('communities')->nullOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('community_sections')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title')->nullable();
            $table->text('description')->nullable();
            
            $table->string('post_status')->default('draft');
            $table->string('visibility')->default('public');
            $table->string('post_type')->default('standard');

            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_sensitive')->default(false);
            $table->boolean('comments_enabled')->default(true);
            $table->boolean('sharing_enabled')->default(true);
 
            $table->timestamp('published_at')->nullable();
            $table->timestamp('edited_at')->nullable();
            $table->timestamps();
            
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
