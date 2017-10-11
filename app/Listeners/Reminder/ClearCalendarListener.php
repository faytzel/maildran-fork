<?php

declare(strict_types=1);

namespace App\Listeners\Reminder;

use App\Events\Event;
use Cache;

class ClearCalendarListener
{
    public function __construct()
    {
        //
    }

    public function handle(Event $event) : void
    {
        Cache::forget('reminder.calendar.user.' . $event->user->id);
    }
}
