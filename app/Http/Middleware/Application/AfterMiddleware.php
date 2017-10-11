<?php

declare(strict_types=1);

namespace App\Http\Middleware\Application;

use Closure;
use Response;
use Session;
use Message;

class AfterMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response) {
            // app version
            $appVersion = app_version();
            if (!is_null($appVersion)) {
                $response->header('X-App-Version', $appVersion);
            }
        }

        // convert "laravel status message" to valid message
        if (Session::has('status')) {
            Message::flashLaravelCompatibility(Session::pull('status'));
        }

        // set previous url in session
        if ($request->method() === 'GET' && $request->route()) {
            Session::setPreviousUrl($request->fullUrl());
        }

        return $response;
    }
}
