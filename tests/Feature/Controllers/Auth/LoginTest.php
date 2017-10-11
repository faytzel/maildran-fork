<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use URL;
use App\Models\UserModel;

class LoginTest extends TestCase
{
    public function testShowLoginForm() : void
    {
        $response = $this->get(URL::route('login'));
        $response->assertStatus(200);
    }

    public function testLogin() : void
    {
        $user = factory(UserModel::class)->create();

        // login without remember
        $response = $this->json('POST', URL::route('login'), [
            'email'    => $user->email,
            'password' => 'secret',
        ]);
        $response->assertRedirect(URL::route('reminder.index'));

        // login with remember
        $response = $this->json('POST', URL::route('login'), [
            'email'    => $user->email,
            'password' => 'secret',
            'remember' => true,
        ]);
        $response->assertRedirect(URL::route('reminder.index'));
    }

    public function testLogout() : void
    {
        $user = factory(UserModel::class)->create();

        $response = $this->actingAs($user)
            ->json('POST', URL::route('logout'));

        $response->assertRedirect(URL::route('home.index'));
    }
}
