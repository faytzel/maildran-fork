<?php

declare(strict_types=1);

namespace App\Events\Reminder;

use App\Events\Event;
use App\Models\UserModel;
use App\Models\ReminderFailedModel;

class FailedEvent extends Event
{
    public $user;
    public $reminderFailed;
    public $reminderFailedType;

    public function __construct(UserModel $user, ReminderFailedModel $reminderFailed, int $reminderFailedType)
    {
        $this->user               = $user;
        $this->reminderFailed     = $reminderFailed;
        $this->reminderFailedType = $reminderFailedType;
    }
}
