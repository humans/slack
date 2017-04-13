<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('channel_id')->unsigned();
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');

            $table->integer('messageable_id')->unsigned();
            $table->string('messageable_type');

            $table->string('content');

            // message, action
            $table->string('type')->default('message');

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
        Schema::dropIfExists('messages');
    }
}
