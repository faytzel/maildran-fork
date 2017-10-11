<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use Request;

class PaginationTest extends TestCase
{
    public function testPaginationValidPage() : void
    {
        $this->assertFalse(pagination_valid_page());

        Request::replace(['page' => 0]);
        $this->assertFalse(pagination_valid_page());

        Request::replace(['page' => 1]);
        $this->assertFalse(pagination_valid_page());

        Request::replace(['page' => 2]);
        $this->assertTrue(pagination_valid_page());
    }
}
