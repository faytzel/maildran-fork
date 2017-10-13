<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Artisan;

class StoreTest extends TestCase
{
    public function testRun() : void
    {
        // For test this artisan command, you must get Mailgun credentials
        // Artisan::call('app:reminder:store');
        // $this->assertRegExp('/Finished$/', Artisan::output());

        // When you get Mailgun credentials, remove this and the next line
        $this->assertTrue(true);
    }
}
