<?php

declare(strict_types=1);

namespace Routes\Web;

use Route;
use RouteGenerator;

class ContactRoute
{
    public function handle()
    {
        RouteGenerator::resource('contact', 'ContactController', [
            'new', 'create',
        ]);

        Route::get('contact/success', 'ContactController@success')
            ->name('contact.success');
    }
}
