<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class StringTest extends TestCase
{
    public function testStringCollapseWhitespace() : void
    {
        $this->assertEquals(string_collapse_whitespace(''), '');
        $this->assertEquals(string_collapse_whitespace(' a b '), 'a b');
        $this->assertEquals(string_collapse_whitespace(' a     b '), 'a b');
    }

    public function testStringGetToken() : void
    {
        $this->assertNotEmpty(string_get_token(null));
        $this->assertNotEmpty(string_get_token('test'));
    }

    public function testStringToLink() : void
    {
        $this->assertEquals(string_to_link('a'), 'a');
        $this->assertRegExp('/b \<a href="https\:\/\/example\.com"/', string_to_link('b https://example.com'));
    }
}
