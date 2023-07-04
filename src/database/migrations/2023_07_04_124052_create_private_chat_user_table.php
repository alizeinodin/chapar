<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('private_chat_user', function (Blueprint $table) {
            $table->id();
            // private chat id as foreign key
            $table->foreignId('private_chat_id')
                ->constrained('private_chats', 'id')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            // user id as foreign key
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('private_chat_user');
    }
};
