<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Events\Auth\RegisteredEvent;
use Illuminate\Http\Request as HttpRequest;
use URL;
use App;
use Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');

        $this->redirectTo = URL::route('register.success');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'                => ['required', 'string', 'email', 'email_not_temporal', 'max:255', 'unique:users'],
            'legal'                => ['accepted'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(HttpRequest $request)
    {
        $input = $request->all();
        $input['password'] = str_random(mt_rand(10, 20));

        $this->validator($input)->validate();

        $user = $this->create($input);
        event(new RegisteredEvent($user, $input));

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    public function success()
    {
        return Response::html('auth.register.success');
    }

    public function showRegistrationForm()
    {
        return Response::html('auth.register.form');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return repo('user')->create($data['email'], $data['password']);
    }
}
