<?php

declare(strict_types=1);

namespace Routes\Web;

use Route;

class HomeRoute
{
    public function handle()
    {
        Route::middleware('guest')
            ->group(function () {
                Route::get('', 'HomeController@index')
                    ->name('home.index');
            });
    }
}
