<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use URL;

class LegalTest extends TestCase
{
    public function testTos() : void
    {
        $response = $this->get(URL::route('legal.tos'));
        $response->assertStatus(200);
    }

    public function testPrivacy() : void
    {
        $response = $this->get(URL::route('legal.privacy'));
        $response->assertStatus(200);
    }

    public function testCookie() : void
    {
        $response = $this->get(URL::route('legal.cookie'));
        $response->assertStatus(200);
    }
}
