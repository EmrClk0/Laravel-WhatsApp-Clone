<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalChatMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_chat_messages', function (Blueprint $table) {
            $table->id(); //mesaj id
            $table->integer("chat_id");
            $table->integer("from");
            $table->string("message_type")->default("text");
            $table->longText("message");
            $table->integer("seen")->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_chat_messages');
    }
}
