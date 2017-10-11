<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\UserModel;

interface UserRepositoryContract
{
    public function create(string $email, string $password) : UserModel;

    public function findByEmailAndEmailReminderCode(string $email, string $emailReminderCode) : ?UserModel;

    public function findByIdAndCalendarToken(int $id, string $token) : ?UserModel;

    public function activate(UserModel $user) : int;

    public function countActivated() : int;

    public function updatePassword(UserModel $user, string $password) : int;

    public function updateTimezone(UserModel $user, string $timezone) : int;

    public function updateEmailReminderCode(UserModel $user, string $emailReminderCode) : int;

    public function updateReminderMoment(
        UserModel $user,
        string $morning,
        string $midday,
        string $afternoon,
        string $night,
        int $emptySubjectSkipped
    ) : int;

    public function delete(UserModel $user, ?string $reason) : int;
}
