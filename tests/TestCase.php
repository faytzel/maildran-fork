<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Captcha;
use Artisan;
use DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();

        // reset database
        $this->resetDatabase();

        Captcha::shouldReceive('verifyResponse')
            ->andReturn(true);

        Captcha::shouldReceive('render')
            ->andReturn('');
    }

    protected function resetDatabase()
    {
        // drop tables
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::statement('DROP TABLE IF EXISTS users');
        DB::statement('DROP TABLE IF EXISTS sessions');
        DB::statement('DROP TABLE IF EXISTS reminders_failed');
        DB::statement('DROP TABLE IF EXISTS reminders');
        DB::statement('DROP TABLE IF EXISTS password_resets');
        DB::statement('DROP TABLE IF EXISTS notifications');
        DB::statement('DROP TABLE IF EXISTS migrations');
        DB::statement('DROP TABLE IF EXISTS jobs');
        DB::statement('DROP TABLE IF EXISTS failed_jobs');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        // create tables
        Artisan::call('migrate', ['--seed' => true]);
    }
}
