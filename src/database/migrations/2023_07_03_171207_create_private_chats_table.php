<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('private_chats', function (Blueprint $table) {
            $table->id();

            // foreign key for sender
            $table->foreignId('userOne_id')
                ->constrained(
                    'users',
                    'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            // foreign key for receiver
            $table->foreignId('userTwo_id')
                ->constrained(
                    'users',
                    'id')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('chat_id')->unique(); // chat of user1, user2 and user2, user1 is same

            $table->timestamps();
        });

        DB::table('private_chats')->get()->each(function ($chat) {
            $userIds = [$chat->user1_id, $chat->user2_id];
            sort($userIds);
            $chatId = implode('_', $userIds);
            DB::table('private_chats')->where('id', $chat->id)->update(['chat_id' => $chatId]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
