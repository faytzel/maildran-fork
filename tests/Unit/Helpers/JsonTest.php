<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class JsonTest extends TestCase
{
    public function testJsonError() : void
    {
        $json = json_decode('{"a":2}');
        $this->assertFalse(json_error($json));

        $jsonInvalid = json_decode('a');
        $this->assertTrue(json_error($jsonInvalid));
    }
}
