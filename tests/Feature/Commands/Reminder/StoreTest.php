<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Artisan;

class StoreTest extends TestCase
{
    public function testRun() : void
    {
        Artisan::call('app:reminder:store');
        $this->assertRegExp('/Finished$/', Artisan::output());
    }
}
