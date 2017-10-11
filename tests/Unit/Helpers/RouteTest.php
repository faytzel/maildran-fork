<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class RouteTest extends TestCase
{
    public function testRouteLoad() : void
    {
        $this->assertNull(route_load('Web'));
    }
}
