<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request as HttpRequest;
use URL;
use Response;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = URL::route('reminder.index');

        $this->middleware('guest');
    }

    public function showResetForm(HttpRequest $request, $token = null)
    {
        return Response::html('auth.passwords.formResetToken', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    protected function sendResetFailedResponse(HttpRequest $request, $response)
    {
        return Response::json(
            ['email' => trans($response)],
            422
        );
    }

    protected function rules()
    {
        return [
            'token'                => ['required'],
            'email'                => ['required', 'email'],
            'password'             => ['required', 'confirmed', 'min:6'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ];
    }
}
