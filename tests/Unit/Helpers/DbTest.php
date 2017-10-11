<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class DbTest extends TestCase
{
    public function testDbEscape() : void
    {
        $this->assertEquals(db_escape('"'), '\'\"\'');
    }

    public function testDbEscapeLike() : void
    {
        $this->assertEquals(db_escape_like('%'), '\%');
    }
}
