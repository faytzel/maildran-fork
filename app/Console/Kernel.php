<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Cache\TemporalClearCommand::class,
        \App\Console\Commands\Reminder\StoreCommand::class,
        \App\Console\Commands\Reminder\RememberCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $filenameSchedule = storage_path('logs/schedule-' . date('Y-m-d') . '.log');

        $schedule->command(\App\Console\Commands\Reminder\StoreCommand::class)
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo($filenameSchedule);

        $schedule->command(\App\Console\Commands\Reminder\RememberCommand::class)
            ->everyMinute()
            ->withoutOverlapping()
            ->appendOutputTo($filenameSchedule);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        route_load('Console');
    }
}
