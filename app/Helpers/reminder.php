<?php

declare(strict_types=1);

function reminder_get_email_code(string $email) : ?string
{
    $emailDomain = Config::get('services.mailgun.receiveDomain');

    $matches = matches('/^([A-Za-z0-9]{6,40})@' . preg_quote($emailDomain, '/') . '$/', $email);
    if (isset($matches[0][1])) {
        return Stringy::toLowerCase($matches[0][1]);
    }

    return null;
}
