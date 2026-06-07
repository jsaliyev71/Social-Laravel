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
        Schema::create('community_sections', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            
            $table->foreignId('community_id')->constrained('communities')->cascadeOnDelete();

            $table->string('color')->nullable();
            $table->string('section_pic')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->text('description')->nullable();

            $table->timestamps();

            $table->unique(['community_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('community_sections');
    }
};
