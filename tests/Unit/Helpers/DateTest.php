<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Models\UserModel;
use Carbon;
use stdClass;

class DateTest extends TestCase
{
    public function testDatePrintable() : void
    {
        $date      = Carbon::create(2017, 3, 4, 5, 6);
        $user      = factory(UserModel::class)->create();
        $dateRegex = '/^[0-9]{2}\-[0-9]{2}\-[0-9]{4}$/';

        $this->assertRegExp($dateRegex, date_printable($date));
        $this->assertRegExp($dateRegex, date_printable($date, $user));
    }

    public function testDatetimePrintable() : void
    {
        $date          = Carbon::create(2017, 3, 4, 5, 6);
        $user          = factory(UserModel::class)->create();
        $datetimeRegex = '/^[0-9]{2}\-[0-9]{2}\-[0-9]{4}\s[0-9]{2}\:[0-9]{2}$/';

        $this->assertRegExp($datetimeRegex, datetime_printable($date));
        $this->assertRegExp($datetimeRegex, datetime_printable($date, $user));
    }

    public function testDateAgo() : void
    {
        $date = Carbon::create(2017, 3, 4, 5, 6);

        $this->assertNotEmpty(date_ago($date));
    }

    public function testDateSplitTime() : void
    {
        $time = date_split_time('12:30:00');

        $this->assertInstanceOf(stdClass::class, $time);
        $this->assertEquals($time->hour, 12);
        $this->assertEquals($time->minute, 30);
    }

    public function testDateTimezoneList() : void
    {
        $this->assertArrayHasKey('UTC', date_timezone_list());
    }
}
