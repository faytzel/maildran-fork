<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class DeleteFormRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'password' => ['required', 'string', 'password'],
            'reason'   => ['nullable', 'string'],
        ];
    }
}
