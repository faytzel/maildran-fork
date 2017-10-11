<?php

declare(strict_types=1);

use App\Exceptions\Helpers\FormException;

function form_input_datetime(Carbon\Carbon $date) : string
{
    if (!Auth::check()) {
        throw new FormException('Must be logged');
    }

    $date->timezone(Auth::user()->timezone);

    return $date->format('Y-m-d\TH:i');
}

function form_input_time(string $time) : string
{
    return date('H:i', strtotime($time));
}

function form_back() : string
{
    return '<input type="hidden" name="_back" value="' . e(URL::previous()) . '">';
}
