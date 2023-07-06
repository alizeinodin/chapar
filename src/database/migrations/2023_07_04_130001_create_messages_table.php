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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('private_chat_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('sender_id')
                ->constrained('users', 'id')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('receiver_id')
                ->constrained('users', 'id')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->json('content');

            $table->boolean('is_delete')->default(false);

            $table->timestamps();
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
