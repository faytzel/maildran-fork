<?php

declare(strict_types=1);

namespace App\Extensions\Validators;

use Carbon;

class DatetimeValidator
{
    public function validateTime($attribute, $value, $parameters)
    {
        if (preg_match('/^[0-9]{2}\:[0-9]{2}$/', $value)) {
            $time   = explode(':', $value);
            $hour   = (int) $time[0];
            $minute = (int) $time[1];

            if ($hour >= 0 && $hour <= 23 && $minute >= 0 && $minute <= 59) {
                return true;
            }
        }

        return false;
    }
}
