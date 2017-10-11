<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\UserModel::class, function (Faker\Generator $faker) {
    static $password;

    $email = $faker->unique()->email;

    return [
        'email'                             => $email,
        'email_reminder_code'               => Stringy::toLowerCase(str_random(mt_rand(10, 20))),
        'password'                          => $password ?: $password = bcrypt('secret'),
        'remember_token'                    => str_random(10),
        'calendar_token'                    => string_get_token($email),
        'timezone'                          => 'Europe/Madrid',
        'activated_at'                      => Carbon::now(),
        'reminder_morning_at'               => '09:30:00',
        'reminder_midday_at'                => '12:00:00',
        'reminder_afternoon_at'             => '17:00:00',
        'reminder_night_at'                 => '21:15:00',
        'reminder_empty_subject_skipped_at' => 3,
    ];
});

$factory->define(App\Models\ReminderModel::class, function (Faker\Generator $faker) {

    $text        = $faker->text;
    $scheduledAt = Carbon::yesterday();

    return [
        'mail_id'          => $faker->md5,
        'user_id'          => function () {
            return factory(App\Models\UserModel::class)->create()->id;
        },
        'message'          => $text,
        'message_raw'      => $text,
        'scheduled_at'     => $scheduledAt,
        'scheduled_at_raw' => $scheduledAt->format('d/m/Y H:i'),
    ];
});

$factory->define(App\Models\ReminderFailedModel::class, function (Faker\Generator $faker) {

    $mailId  = $faker->md5;
    $text    = $faker->text;
    $user    = factory(App\Models\UserModel::class)->create();
    $dateNow = Carbon::now();

    return [
        'mail_id'    => $mailId,
        'user_id'    => $user->id,
        'mail'       => array_to_object([
            'id'               => $mailId,
            'email'            => $user->email,
            'message'          => $text,
            'message_raw'      => $text,
            'scheduled_at_raw' => 'fake date',
            'created_at'       => $dateNow,
            'scheduled_at'     => null,
        ]),
        'created_at' => $dateNow,
    ];
});
