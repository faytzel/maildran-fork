<?php

declare(strict_types=1);

function date_printable(Carbon\Carbon $date, App\Models\UserModel $user = null) : string
{
    if (Auth::check()) {
        $date->timezone(Auth::user()->timezone);
    } elseif (c_one($user)) {
        $date->timezone($user->timezone);
    }

    return $date->format('d-m-Y');
}

function datetime_printable(Carbon\Carbon $date, App\Models\UserModel $user = null) : string
{
    if (Auth::check()) {
        $date->timezone(Auth::user()->timezone);
    } elseif (c_one($user)) {
        $date->timezone($user->timezone);
    }

    return $date->format('d-m-Y H:i');
}

function date_ago(Carbon\Carbon $date) : string
{
    return Date::createFromTimeStampUTC($date->timezone('UTC')->timestamp)->ago();
}

function date_split_time(string $time) : stdClass
{
    $timeSplitted = explode(':', $time);

    $result         = new stdClass();
    $result->hour   = (int) $timeSplitted[0];
    $result->minute = (int) $timeSplitted[1];

    return $result;
}

function date_timezone_list() : array
{
    $list   = DateTimeZone::listAbbreviations();
    $idents = DateTimeZone::listIdentifiers();

    $data = $offset = $added = [];
    foreach ($list as $abbr => $info) {
        foreach ($info as $zone) {
            if (!empty($zone['timezone_id'])
                && !in_array($zone['timezone_id'], $added)
                && in_array($zone['timezone_id'], $idents)
            ) {
                $z        = new DateTimeZone($zone['timezone_id']);
                $c        = new DateTime('now', $z);
                $data[]   = $zone;
                $offset[] = $z->getOffset($c);
                $added[]  = $zone['timezone_id'];
            }
        }
    }

    array_multisort($offset, SORT_ASC, $data);
    $options = [];
    foreach ($data as $key => $row) {
        // genera un nombre amigable sobre la localizacion de la zona horaria
        $city = explode('/', str_replace('_', ' ', $row['timezone_id']));
        if (count($city) > 1) {
            unset($city[0]);
            $city = implode(' - ', $city);
        } else {
            $city = $city[0];
        }

        $options[$row['timezone_id']] = date_timezone_list_callback($row['offset']) . ' ' . $city;
    }

    return $options;
}

function date_timezone_list_callback(int $offset) : string
{
    $hours     = $offset / 3600;
    $remainder = $offset % 3600;
    $sign      = $hours > 0 ? '+' : '-';
    $hour      = (int) abs($hours);
    $minutes   = (int) abs($remainder / 60);

    if ($hour == 0 && $minutes == 0) {
        $sign = ' ';
    }

    return 'GMT ' . $sign . str_pad((string) $hour, 2, '0', STR_PAD_LEFT) .':'. str_pad((string) $minutes, 2, '0');
}
