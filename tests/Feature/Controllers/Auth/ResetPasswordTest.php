<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use URL;
use App\Models\UserModel;
use DB;

class ResetPasswordTest extends TestCase
{
    public function testShowResetForm() : void
    {
        $user = $this->sendEmailResetPassword();

        $response = $this->json('GET', URL::route('password.reset', ['token' => 'tokensecret']));
        $response->assertStatus(200);
    }

    public function testReset() : void
    {
        $user = $this->sendEmailResetPassword();

        $response = $this->json('POST', URL::action('Auth\ResetPasswordController@reset'), [
            'token'                 => 'tokensecret',
            'email'                 => $user->email,
            'password'              => 'newpassword',
            'password_confirmation' => 'newpassword',
            'g-recaptcha-response'  => 'test',
        ]);
        $response->assertRedirect(URL::route('reminder.index'));
    }

    protected function sendEmailResetPassword() : UserModel
    {
        $user = factory(UserModel::class)->create();

        $response = $this->json('POST', URL::route('password.email'), [
            'email'                => $user->email,
            'g-recaptcha-response' => 'test',
        ]);

        // set new token por reset password
        DB::table('password_resets')
            ->where('email', $user->email)
            ->update([
                'token' => bcrypt('tokensecret'),
            ]);

        return $user;
    }
}
