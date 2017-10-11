<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use ViewLayout;
use stdClass;

class ViewLayoutTest extends TestCase
{
    public function testTitle() : void
    {
        $this->assertNotEmpty(ViewLayout::title());
    }

    public function testDescription() : void
    {
        $this->assertNotEmpty(ViewLayout::description());
    }

    public function testRobots() : void
    {
        $this->assertNotEmpty(ViewLayout::robots());
    }

    public function testOpenGraph() : void
    {
        $openGraph = ViewLayout::openGraph();

        $this->assertInstanceOf(stdClass::class, $openGraph);
        $this->assertObjectHasAttribute('title', $openGraph);
        $this->assertObjectHasAttribute('url', $openGraph);
        $this->assertObjectHasAttribute('description', $openGraph);
        $this->assertObjectHasAttribute('image', $openGraph);
        $this->assertObjectHasAttribute('siteName', $openGraph);
        $this->assertObjectHasAttribute('domain', $openGraph);
    }
}
