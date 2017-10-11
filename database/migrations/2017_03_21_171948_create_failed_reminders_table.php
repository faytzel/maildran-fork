<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailedRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_reminders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mail_id')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->longText('mail');
            $table->timestamp('created_at')->nullable();

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
        Schema::dropIfExists('failed_reminders');
    }
}
