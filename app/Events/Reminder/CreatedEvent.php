<?php

declare(strict_types=1);

namespace App\Events\Reminder;

use App\Events\Event;
use App\Models\UserModel;
use App\Models\ReminderModel;

class CreatedEvent extends Event
{
    public $user;
    public $reminder;

    public function __construct(UserModel $user, ReminderModel $reminder)
    {
        $this->user     = $user;
        $this->reminder = $reminder;
    }
}
