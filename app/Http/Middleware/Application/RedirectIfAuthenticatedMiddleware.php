<?php

declare(strict_types=1);

namespace App\Http\Middleware\Application;

use Closure;
use Auth;
use Redirect;

class RedirectIfAuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return Redirect::route('reminder.index');
        }

        return $next($request);
    }
}
