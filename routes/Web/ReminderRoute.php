<?php

declare(strict_types=1);

namespace Routes\Web;

use Route;
use RouteGenerator;

class ReminderRoute
{
    public function handle()
    {
        // AUTH
        Route::middleware('auth')
            ->group(function () {
                RouteGenerator::resource('reminder', 'ReminderController', [
                    'index', 'edit', 'update', 'delete',
                ]);
                Route::prefix('reminder')
                    ->group(function () {
                        Route::get('notified', 'ReminderController@notified')
                            ->name('reminder.notified');
                        Route::get('maildran-reminder.vcf', 'ReminderController@vcard')
                            ->name('reminder.vcard');
                    });
            });

        // AUTH AND GUEST
        Route::prefix('reminder')
            ->group(function () {
                Route::get('calendar/{userForCalendar}/{token}/ical.ics', 'ReminderController@calendar')
                    ->name('reminder.calendar');
            });
    }
}
