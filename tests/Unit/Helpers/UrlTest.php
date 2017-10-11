<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use Config;

class UrlTest extends TestCase
{
    public function testUrlIsAppDomain() : void
    {
        $this->assertTrue(url_is_app_domain('https://' . Config::get('app.domains.web')));

        $this->assertFalse(url_is_app_domain('sdgsdg'));
        $this->assertFalse(url_is_app_domain('http://test.com'));
    }
}
