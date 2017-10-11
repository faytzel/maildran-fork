<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use Console;

class ConsoleTest extends TestCase
{
    public function testRun() : void
    {
        $this->assertEquals('a', Console::run('echo "a"'));
    }

    public function testEscapeArgument() : void
    {
        $this->assertEquals('\'"a"\'', Console::escapeArgument('"a"'));
    }
}
