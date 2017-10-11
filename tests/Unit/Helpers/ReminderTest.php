<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use Config;

class ReminderTest extends TestCase
{
    public function testReminderGetEmailCode() : void
    {
        $domain = Config::get('services.mailgun.receiveDomain');

        $this->assertRegExp(
            '/^[a-z0-9]{6,40}$/',
            reminder_get_email_code('qwertyuiopasdfghjklzxcvbnm12345678795dff@' . $domain)
        );
        $this->assertRegExp(
            '/^[a-z0-9]{6,40}$/',
            reminder_get_email_code('qweRTyuiopasdfghjklzxcvbnm12345678795dff@' . $domain)
        );
        $this->assertRegExp(
            '/^[a-z0-9]{6,40}$/',
            reminder_get_email_code('zxcvbnm12345678795dff@' . $domain)
        );
        $this->assertNull(reminder_get_email_code('qwertyuiopasdfghjklzxcvbnm12345678795dff@example.com'));
        $this->assertNull(reminder_get_email_code('abcd@example.com'));
    }
}
