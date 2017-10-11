<?php

namespace App\Policies;

use App\Models\UserModel;
use App\Models\ReminderModel;

class ReminderPolicy extends Policy
{
    public function update(UserModel $user, ReminderModel $reminder)
    {
        return $user->id === $reminder->user_id;
    }

    public function delete(UserModel $user, ReminderModel $reminder)
    {
        return $user->id === $reminder->user_id;
    }
}
