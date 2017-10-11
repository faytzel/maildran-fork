<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /**
         * Reminder
         */
        \App\Events\Reminder\CreatedEvent::class => [
            \App\Listeners\Reminder\SendCreateNotificationListener::class,
            \App\Listeners\Reminder\ClearCalendarListener::class,
        ],
        \App\Events\Reminder\UpdatedEvent::class => [
            \App\Listeners\Reminder\ClearCalendarListener::class,
        ],
        \App\Events\Reminder\DeletedEvent::class => [
            \App\Listeners\Reminder\ClearCalendarListener::class,
        ],
        \App\Events\Reminder\FailedEvent::class => [
            \App\Listeners\Reminder\SendInvalidNotificationListener::class,
        ],

        /**
         * User
         */
        \App\Events\User\UpdatedTimezoneEvent::class => [
            \App\Listeners\Reminder\ClearCalendarListener::class,
        ],

        /**
         * Authentcation
         */
        \App\Events\Auth\RegisteredEvent::class => [
            \App\Listeners\Auth\SendEmailRegisterListener::class,
        ],
        \Illuminate\Auth\Events\Attempting::class => [
            //
        ],
        \Illuminate\Auth\Events\Authenticated::class => [
            \App\Listeners\Auth\UserActivateListener::class,
        ],
        \Illuminate\Auth\Events\Login::class => [
            //
        ],
        \Illuminate\Auth\Events\Failed::class => [
            //
        ],
        \Illuminate\Auth\Events\Logout::class => [
            //
        ],
        \Illuminate\Auth\Events\Lockout::class => [
            //
        ],

        /**
         * Cache
         */
        \Illuminate\Cache\Events\CacheHit::class => [
            //
        ],
        \Illuminate\Cache\Events\CacheMissed::class => [
            //
        ],
        \Illuminate\Cache\Events\KeyForgotten::class => [
            //
        ],
        \Illuminate\Cache\Events\KeyWritten::class => [
            //
        ],

        /**
         * Mail
         */
        \Illuminate\Mail\Events\MessageSending::class => [
            //
        ],

        /**
         * Notifications
         */
        \Illuminate\Notifications\Events\NotificationSent::class => [
            //
        ],

        /**
         * Queue
         */
        \Illuminate\Queue\Events\JobExceptionOccurred::class => [
            //
        ],
        \Illuminate\Queue\Events\JobFailed::class => [
            \App\Listeners\Queue\SendQueueJobFailedNotificationListener::class,
        ],
        \Illuminate\Queue\Events\JobProcessed::class => [
            //
        ],
        \Illuminate\Queue\Events\JobProcessing::class => [
            //
        ],
        \Illuminate\Queue\Events\Looping::class => [
            \App\Listeners\Queue\ClearPreviousQueueJobFailedListener::class,
        ],
        \Illuminate\Queue\Events\WorkerStopping::class => [
            //
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        //
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
