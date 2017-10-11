<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Artisan;

class TemporalClearTest extends TestCase
{
    public function testRun() : void
    {
        Artisan::call('app:cache-temporal:clear');
        $this->assertRegExp('/Finished$/', Artisan::output());
    }
}
