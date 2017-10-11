<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class UpdateEmailReminderCodeFormRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'email_code' => ['required', 'string', 'regex:/^[a-z0-9]+$/', 'min:6', 'max:40'],
        ];
    }
}
