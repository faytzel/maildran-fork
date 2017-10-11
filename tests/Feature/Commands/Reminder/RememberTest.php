<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Artisan;
use App\Models\ReminderModel;

class RememberTest extends TestCase
{
    public function testRun() : void
    {
        // create reminder
        factory(ReminderModel::class)->create();

        // call command
        Artisan::call('app:reminder:remember');

        // get reminders notified
        $output            = Artisan::output();
        $matches           = matches('/Reminders notified: ([0-9]+)\n/', $output);
        $remindersNotified = (int) $matches[0][1];

        $this->assertGreaterThanOrEqual(1, $remindersNotified);
        $this->assertRegExp('/Finished$/', $output);
    }
}
