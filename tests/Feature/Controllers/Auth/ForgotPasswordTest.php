<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use URL;
use App\Models\UserModel;

class ForgotPasswordTest extends TestCase
{
    public function testShowLinkRequestForm() : void
    {
        $response = $this->get(URL::route('password.request'));
        $response->assertStatus(200);
    }

    public function testSendResetLinkEmail() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->json('POST', URL::route('password.email'), [
            'email'                => $user->email,
            'g-recaptcha-response' => 'test',
        ]);
        $response->assertRedirect(URL::route('password.request'));
    }
}
