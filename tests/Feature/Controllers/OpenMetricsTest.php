<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use URL;

class OpenMetricsTest extends TestCase
{
    public function testIndex() : void
    {
        $response = $this->get(URL::route('openMetrics.index'));
        $response->assertStatus(200);
    }
}
