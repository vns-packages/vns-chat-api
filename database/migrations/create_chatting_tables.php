<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChattingTables extends Migration
{
    public function up()
    {
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_group')->default(false);
            $table->foreignId('group_admin_id')->nullable();

            $table->timestamps();
        });

        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->string('type')->default('text');

            $table->foreignId('reply_to_id')->nullable()->references('id')->on('chat_messages');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('conversation_id')->references('id')->on('chat_conversations')->cascadeOnDelete();

            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });

        Schema::create('chat_conversation_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('conversation_id')->references('id')->on('chat_conversations')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_conversations');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_conversation_user');
        Schema::dropIfExists('chat_message_notifications');
    }
}
