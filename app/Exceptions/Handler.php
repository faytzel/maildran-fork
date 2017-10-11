<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\SuspiciousOperationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Sentry;
use Exception;
use Response;
use URL;
use Config;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
        SuspiciousOperationException::class,
    ];

    protected $dontRenderViewError500 = [
        HttpResponseException::class,
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // envia a Sentry
        if ($this->shouldReport($exception)) {
            Sentry::sendException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // csrf exception
        if ($request->expectsJson() && $exception instanceof TokenMismatchException) {
            return Response::json(['error' => 'CSRF Failed.'], 412);
        }

        // show custom page 500 when throw exception
        if ($this->shouldRenderViewError500($exception)) {
            $newException = new HttpException(500, 'Internal Server Error');
            return $this->renderHttpException($newException);
        }

        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return Response::json([
                'error' => 'Unauthenticated.',
                'url'   => URL::route('login'),
            ], 401);
        }

        return redirect()->guest(route('login'));
    }

    protected function shouldRenderViewError500(Exception $exception) : bool
    {
        if (Config::get('app.debug')) {
            return false;
        }

        foreach ($this->dontRenderViewError500 as $exceptionType) {
            if ($exception instanceof $exceptionType) {
                return false;
            }
        }

        return true;
    }
}
