<?php

declare(strict_types=1);

namespace App\Listeners\Reminder;

use App\Events\Event;
use App\Notifications\Reminder\CreateNotification;

class SendCreateNotificationListener
{
    public function __construct()
    {
        //
    }

    public function handle(Event $event) : void
    {
        // notification reminder saved
        $event->user->notify(new CreateNotification($event->reminder));
    }
}
