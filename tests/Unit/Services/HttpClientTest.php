<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use HttpClient;
use stdClass;
use SimpleXMLElement;

class HttpClientTest extends TestCase
{
    public function testGetJson() : void
    {
        $response = HttpClient::getJson('https://jsonfeed.org/feed.json');

        $this->assertInstanceOf(stdClass::class, $response);
    }

    public function testGetXml() : void
    {
        $response = HttpClient::getXml('https://jsonfeed.org/xml/rss.xml');

        $this->assertInstanceOf(SimpleXMLElement::class, $response);
    }
}
