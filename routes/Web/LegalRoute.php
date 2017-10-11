<?php

declare(strict_types=1);

namespace Routes\Web;

use Route;

class LegalRoute
{
    public function handle()
    {
        Route::prefix('legal')
            ->group(function () {
                Route::get('terms-of-use', 'LegalController@tos')
                    ->name('legal.tos');

                Route::get('privacy', 'LegalController@privacy')
                    ->name('legal.privacy');

                Route::get('cookie-law', 'LegalController@cookie')
                    ->name('legal.cookie');
            });
    }
}
