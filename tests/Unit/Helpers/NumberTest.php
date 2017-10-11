<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class NumberTest extends TestCase
{
    public function testIsId() : void
    {
        $this->assertFalse(is_id(0));
        $this->assertTrue(is_id(1));
    }

    public function testIsNatural() : void
    {
        $this->assertTrue(is_natural(0));
        $this->assertTrue(is_natural(1));
    }

    public function testIsNaturalNoZero() : void
    {
        $this->assertFalse(is_natural_no_zero(0));
        $this->assertTrue(is_natural_no_zero(1));
    }
}
