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
        Schema::create('likes', function (Blueprint $table) {
            $table->id();

            // Foreign key linked to users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Foreign key linked to image
            // Had to check this one, had to change constrain value as normally image_id would check for a table images, but I called mine something different.
            $table->foreignId('image_id')->constrained('hosted_images')->cascadeOnDelete();

            // Assures that 1 user can only like an image once
            $table->unique(['user_id', 'image_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
