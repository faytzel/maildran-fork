<?php

declare(strict_types=1);

namespace App\Http\Requests\Contact;

use App\Http\Requests\FormRequest;

class CreateFormRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'email_not_temporal', 'max:255'],
            'subject'              => ['required', 'string', 'max:255'],
            'message'              => ['required', 'string'],
            'legal'                => ['accepted'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ];
    }

    public function messages() : array
    {
        return [];
    }
}
