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
        Schema::create('hosted_images', function (Blueprint $table) {
            $table->id();

            // Name for file
            $table->string('file_name');

            // Named version for file - nullable for now, as will be assigned value later
            $table->string('file_renamed')->nullable();

            // Foregin key to link to user
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Folder path
            $table->string('path');

            // Size of file, used for verification - max file size limits
            $table->integer('file_size');

            // File type - .jpg, .png whatever
            $table->string('file_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hosted_images');
    }
};
