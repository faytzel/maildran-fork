<?php

declare(strict_types=1);

namespace App\Console\Commands\Reminder;

use App\Notifications\Reminder\RememberNotification;
use App\Console\Commands\Command;
use DB;

class RememberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reminder:remember';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handleCallback() : void
    {
        // get reminders (previous current date)
        $reminders = repo('reminder')->findPastNotNotified();
        foreach ($reminders as $reminder) {
            DB::transaction(function () use ($reminder) {
                // mark withh notified
                repo('reminder')->markNotified($reminder);

                // send notification
                $reminder->user->notify(new RememberNotification($reminder));
            });
        }

        $this->log('Reminders notified: ' . count($reminders), self::LOG_LEVEL_INFO);
    }
}
