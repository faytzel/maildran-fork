<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use HttpClient;
use URL;
use stdClass;
use SimpleXMLElement;

class HttpClientTest extends TestCase
{
    public function testGetJson() : void
    {
        $response = HttpClient::getJson(URL::route('test.json'));

        $this->assertInstanceOf(stdClass::class, $response);
    }

    public function testGetXml() : void
    {
        $response = HttpClient::getXml(URL::route('test.xml'));

        $this->assertInstanceOf(SimpleXMLElement::class, $response);
    }
}
