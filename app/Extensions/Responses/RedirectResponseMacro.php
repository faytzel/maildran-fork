<?php

declare(strict_types=1);

namespace App\Extensions\Responses;

use Illuminate\Http\RedirectResponse;
use Redirect;

class RedirectResponseMacro
{
    public function handle(string $route) : RedirectResponse
    {
        return Redirect::route($route);
    }
}
