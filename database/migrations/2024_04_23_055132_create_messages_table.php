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
            $table->id();
            $table->string('sender_email');
            $table->string('receiver_email');
            $table->text('message');
            $table->enum('status', ['read', 'unread'])->default('unread');
            $table->timestamps();

            $table->foreign('sender_email')->references('sender_email')->on('friend_requests')->onDelete('cascade');
            $table->foreign('receiver_email')->references('receiver_email')->on('friend_requests')->onDelete('cascade');
            
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
