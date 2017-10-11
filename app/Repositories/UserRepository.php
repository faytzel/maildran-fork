<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserModel;
use App\Contracts\Repositories\UserRepositoryContract;
use Carbon;
use Stringy;

class UserRepository implements UserRepositoryContract
{
    public function create(string $email, string $password) : UserModel
    {
        return UserModel::create([
            'email'               => $email,
            'password'            => bcrypt($password),
            'email_reminder_code' => Stringy::toLowerCase(str_random(mt_rand(10, 20))),
            'calendar_token'      => string_get_token($email),
        ]);
    }

    public function findByEmailAndEmailReminderCode(string $email, string $emailReminderCode) : ?UserModel
    {
        return UserModel::activated()
            ->where('email', $email)
            ->where('email_reminder_code', $emailReminderCode)
            ->first();
    }

    public function findByIdAndCalendarToken(int $id, string $token) : ?UserModel
    {
        return UserModel::activated()
            ->where('id', $id)
            ->where('calendar_token', $token)
            ->first();
    }

    public function activate(UserModel $user) : int
    {
        if (is_null($user->activated_at)) {
            return UserModel::where('id', $user->id)
                ->update([
                    'activated_at' => Carbon::now(),
                ]);
        }

        return 0;
    }

    public function countActivated() : int
    {
        return UserModel::activated()
            ->count();
    }

    public function updatePassword(UserModel $user, string $password) : int
    {
        return UserModel::where('id', $user->id)
            ->update([
                'password' => bcrypt($password),
            ]);
    }

    public function updateTimezone(UserModel $user, string $timezone) : int
    {
        return UserModel::where('id', $user->id)
            ->update([
                'timezone' => $timezone
            ]);
    }

    public function updateEmailReminderCode(UserModel $user, string $emailReminderCode) : int
    {
        return UserModel::where('id', $user->id)
            ->update([
                'email_reminder_code' => $emailReminderCode
            ]);
    }

    public function updateReminderMoment(
        UserModel $user,
        string $morning,
        string $midday,
        string $afternoon,
        string $night,
        int $emptySubjectSkipped
    ) : int {
        return UserModel::where('id', $user->id)
            ->update([
                'reminder_morning_at'               => $morning,
                'reminder_midday_at'                => $midday,
                'reminder_afternoon_at'             => $afternoon,
                'reminder_night_at'                 => $night,
                'reminder_empty_subject_skipped_at' => $emptySubjectSkipped,
            ]);
    }

    public function delete(UserModel $user, ?string $reason) : int
    {
        UserModel::where('id', $user->id)
            ->update([
                'deleted_at_reason' => $reason
            ]);

        return UserModel::where('id', $user->id)
            ->delete();
    }
}
