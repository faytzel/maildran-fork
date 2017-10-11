<?php

declare(strict_types=1);

namespace App\Extensions\Validators;

use Auth;

class AuthValidator
{
    public function validatePassword($attribute, $value, $parameters)
    {
        $user        = Auth::user();
        $credentials = [
            'email'    => $user->email,
            'password' => $value,
        ];

        if (Auth::validate($credentials)) {
            return true;
        }

        return false;
    }
}
