<?php

declare(strict_types=1);

namespace App\Http\Middleware\Application;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookiesMiddleware extends BaseEncrypter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'cookieconsent_status',
    ];
}
