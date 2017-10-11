<?php

declare(strict_types=1);

namespace App\Listeners\Reminder;

use App\Events\Event;
use App\Notifications\Reminder\DateInvalidNotification;
use App\Notifications\Reminder\EmptyNotification;
use App\Services\ReminderService;
use App\Exceptions\ListenerException;

class SendInvalidNotificationListener
{
    public function __construct()
    {
        //
    }

    public function handle(Event $event) : void
    {
        // send notification
        if ($event->reminderFailedType == ReminderService::REMINDER_FAILED_EMPTY) {
            $event->user->notify(new EmptyNotification($event->reminderFailed));
        } elseif ($event->reminderFailedType == ReminderService::REMINDER_FAILED_DATE_INVALID) {
            $event->user->notify(new DateInvalidNotification($event->reminderFailed));
        } else {
            throw new ListenerException('Invalid Reminder Failer Type');
        }
    }
}
