<?php

declare(strict_types=1);

namespace App\Listeners\Auth;

use App\Events\Auth\RegisteredEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\Notifications\Auth\RegisterNotification;

class SendEmailRegisterListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(RegisteredEvent $event) : void
    {
        $event->user->notify(new RegisterNotification($event->user->email, $event->input['password']));
    }
}
