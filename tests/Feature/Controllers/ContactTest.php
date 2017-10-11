<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use URL;
use Faker\Factory;

class ContactTest extends TestCase
{
    public function testNew() : void
    {
        $response = $this->get(URL::route('contact.new'));
        $response->assertStatus(200);
    }

    public function testCreate() : void
    {
        $faker = Factory::create();

        $response = $this->json('POST', URL::route('contact.create'), [
            'name'                 => $faker->name,
            'email'                => $faker->email,
            'subject'              => $faker->sentence,
            'message'              => $faker->text,
            'legal'                => true,
            'g-recaptcha-response' => 'test',
        ]);
        $response->assertRedirect(URL::route('contact.success'));
    }

    public function testSuccess() : void
    {
        $response = $this->get(URL::route('contact.success'));
        $response->assertStatus(200);
    }
}
