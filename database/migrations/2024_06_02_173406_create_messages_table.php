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
        Schema::create('messages', function (Blueprint $table) {
            $table->id('messageID');
            $table->unsignedBigInteger('roomID');
            $table->unsignedBigInteger('userID');
            $table->text('content')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->foreign('roomID')->references('roomID')->on('chat_rooms')->onDelete('cascade');
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
