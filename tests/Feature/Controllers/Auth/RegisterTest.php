<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\Auth;

use Tests\TestCase;
use URL;
use Faker\Factory;

class RegisterTest extends TestCase
{
    public function testShowRegistrationForm() : void
    {
        $response = $this->get(URL::route('register'));
        $response->assertStatus(200);
    }

    public function testRegister() : void
    {
        $faker = Factory::create();

        $response = $this->json('POST', URL::route('register'), [
            'email'                => $faker->unique()->email,
            'legal'                => true,
            'g-recaptcha-response' => 'test',
        ]);
        $response->assertRedirect(URL::route('register.success'));
    }

    public function testSuccess() : void
    {
        $response = $this->get(URL::route('register.success'));
        $response->assertStatus(200);
    }
}
