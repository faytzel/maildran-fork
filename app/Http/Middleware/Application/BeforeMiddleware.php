<?php

declare(strict_types=1);

namespace App\Http\Middleware\Application;

use Closure;

class BeforeMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
