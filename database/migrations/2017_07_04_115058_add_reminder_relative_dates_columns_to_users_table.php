<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReminderRelativeDatesColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->time('reminder_morning_at')->default('9:00:00');
            $table->time('reminder_midday_at')->default('12:00:00');
            $table->time('reminder_afternoon_at')->default('17:00:00');
            $table->time('reminder_night_at')->default('21:00:00');
            $table->tinyInteger('reminder_empty_subject_skipped_at')->default(3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'reminder_morning_at',
                'reminder_midday_at',
                'reminder_afternoon_at',
                'reminder_night_at',
                'reminder_empty_subject_skipped_at',
            ]);
        });
    }
}
