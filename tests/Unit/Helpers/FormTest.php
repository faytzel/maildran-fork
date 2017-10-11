<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Models\UserModel;
use Carbon;

class FormTest extends TestCase
{
    public function testFormInputDatetime() : void
    {
        $date      = Carbon::create(2017, 3, 4, 5, 6);
        $user      = factory(UserModel::class)->create();
        $dateRegex = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}T[0-9]{2}\:[0-9]{2}$/';

        // user logged
        $this->actingAs($user);

        $this->assertRegExp($dateRegex, form_input_datetime($date));
    }

    public function testFormInputTime() : void
    {
        $this->assertRegExp('/^[0-9]{2}:[0-9]{2}$/', form_input_time('10:30:00'));
    }

    public function testBack() : void
    {
        $this->assertNotEmpty(form_back());
    }
}
