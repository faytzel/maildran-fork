<?php

declare(strict_types=1);

namespace App\Http\Requests;

class FormRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function authorize() : bool
    {
        return true;
    }
}
