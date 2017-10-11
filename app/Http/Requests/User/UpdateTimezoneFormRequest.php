<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class UpdateTimezoneFormRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'timezone' => ['required', 'string', 'timezone'],
        ];
    }
}
