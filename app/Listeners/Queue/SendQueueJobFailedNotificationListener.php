<?php

declare(strict_types=1);

namespace App\Listeners\Queue;

use Illuminate\Queue\Events\JobFailed;

class SendQueueJobFailedNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JobFailed  $event
     * @return void
     */
    public function handle(JobFailed $event) : void
    {
        //
    }
}
