<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request as HttpRequest;
use Response;
use Redirect;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return Response::html('auth.passwords.formReset');
    }

    protected function sendResetLinkResponse($response)
    {
        return Redirect::route('password.request')
            ->with('status', trans($response));
    }

    protected function sendResetLinkFailedResponse(HttpRequest $request, $response)
    {
        return Response::json(
            ['email' => trans($response)],
            422
        );
    }

    protected function validateEmail(HttpRequest $request)
    {
        $this->validate($request, [
            'email'                => ['required', 'email'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ]);
    }
}
