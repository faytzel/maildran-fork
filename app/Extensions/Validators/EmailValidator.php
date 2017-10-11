<?php

declare(strict_types=1);

namespace App\Extensions\Validators;

use MailChecker;

class EmailValidator
{
    /**
    * Comprueba si un email es temporal
    */
    public function validateEmailNotTemporal($attribute, $value, $parameters)
    {
        if (MailChecker::isValid($value)) {
            return true;
        }

        return false;
    }
}
