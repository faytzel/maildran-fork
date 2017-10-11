<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use RouteGenerator;

class RouteGeneratorTest extends TestCase
{
    public function testResource() : void
    {
        $this->assertNull(RouteGenerator::resource('reminder', 'ReminderController'));
    }
}
