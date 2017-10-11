<?php

declare(strict_types=1);

namespace Routes\Web;

use Auth;
use Route;

class AuthRoute
{
    public function handle()
    {
        Auth::routes();

        Route::get('register/success', 'Auth\RegisterController@success')
            ->name('register.success');
    }
}
