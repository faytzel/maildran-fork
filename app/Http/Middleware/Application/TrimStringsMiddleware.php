<?php

declare(strict_types=1);

namespace App\Http\Middleware\Application;

use Illuminate\Foundation\Http\Middleware\TrimStrings as BaseTrimmer;

class TrimStringsMiddleware extends BaseTrimmer
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];

    protected function transform($key, $value)
    {
        if (in_array($key, $this->except)) {
            return $value;
        }

        return is_string($value) ? string_collapse_whitespace($value) : $value;
    }
}
