<?php

declare(strict_types=1);

namespace Routes\Web;

use Route;

class SettingsRoute
{
    public function handle()
    {
        Route::prefix('settings')
            ->middleware('auth')
            ->group(function () {
                Route::prefix('user')
                    ->group(function () {
                        Route::get('', 'SettingsController@user')
                            ->name('settings.user');

                        Route::put('timezone', 'SettingsController@updateTimezone')
                            ->name('settings.timezone.update');

                        Route::put('password', 'SettingsController@updatePassword')
                            ->name('settings.password.update');

                        Route::delete('', 'SettingsController@deleteUser')
                            ->name('settings.user.delete');
                    });
                Route::prefix('reminder')
                    ->group(function () {
                        Route::get('', 'SettingsController@reminder')
                            ->name('settings.reminder');

                        Route::put('email', 'SettingsController@updateEmailReminderCode')
                            ->name('settings.emailReminderCode.update');

                        Route::put('moment', 'SettingsController@updateReminderMoment')
                            ->name('settings.reminderMoment.update');
                    });
            });
    }
}
