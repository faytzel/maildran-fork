<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequest;

class UpdateReminderMomentFormRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'morning'               => ['required', 'time'],
            'afternoon'             => ['required', 'time'],
            'night'                 => ['required', 'time'],
            'empty_subject_skipped' => ['required', 'integer', 'min:1', 'max:24'],
        ];
    }
}
