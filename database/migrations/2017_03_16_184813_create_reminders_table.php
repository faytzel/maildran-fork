<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mail_id')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->longText('message');
            $table->longText('message_raw');
            $table->text('scheduled_at_raw');
            $table->timestamps();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('notified_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reminders');
    }
}
