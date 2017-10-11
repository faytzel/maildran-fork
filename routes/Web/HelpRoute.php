<?php

declare(strict_types=1);

namespace Routes\Web;

use Route;

class HelpRoute
{
    public function handle()
    {
        Route::prefix('help')
            ->group(function () {
                Route::get('', 'HelpController@index')
                    ->name('help.index');

                Route::get('workflow', 'HelpController@workflow')
                    ->name('help.workflow');

                Route::get('bookmark', 'HelpController@bookmark')
                    ->name('help.bookmark');

                Route::get('reminder/new', 'HelpController@reminderNew')
                    ->name('help.reminderNew');

                Route::get('reminder/datetime', 'HelpController@reminderDatetime')
                    ->name('help.reminderDatetime');
            });
    }
}
