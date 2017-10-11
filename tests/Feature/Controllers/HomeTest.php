<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use URL;

class HomeTest extends TestCase
{
    public function testIndex() : void
    {
        $response = $this->get(URL::route('home.index'));
        $response->assertStatus(200);
    }
}
