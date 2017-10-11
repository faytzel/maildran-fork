<?php

declare(strict_types=1);

namespace App\Http\Requests\Reminder;

use App\Http\Requests\FormRequest;
use Carbon;
use Auth;

class UpdateFormRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'schedule' => ['required', 'string', 'date_format:Y-m-d\TH:i', 'after:now'],
            'message'  => ['required', 'string'],
        ];
    }

    public function messages() : array
    {
        return [];
    }

    protected function validationData()
    {
        $data = $this->all();

        if (array_key_exists('schedule', $data)) {
            $data['schedule'] = Carbon::parse($data['schedule'], Auth::user()->timezone)
                ->setTimezone('UTC')
                ->format('Y-m-d\TH:i');
        }

        return $data;
    }
}
