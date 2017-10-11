<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class UpdatePasswordFormRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'password'     => ['required', 'string', 'password'],
            'new_password' => ['required', 'string', 'confirmed', 'min:6'],
        ];
    }
}
