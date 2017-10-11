<?php

declare(strict_types=1);

namespace App\Services;

use Stringy;
use Carbon;
use Exception;
use Config;
use App\Models\UserModel;

class DateHumanizeService
{
    protected $carbonFormats = [];

    protected $config;
    protected $regex;
    protected $separator;
    protected $replace;
    protected $month;
    protected $dayOfWeek;

    public function __construct()
    {
        $this->config    = Config::get('dateHumanize.es.general');
        $this->regex     = Config::get('dateHumanize.es.regex');
        $this->separator = Config::get('dateHumanize.es.separator');
        $this->replace   = Config::get('dateHumanize.es.replace');
        $this->month     = Config::get('dateHumanize.es.month');
        $this->dayOfWeek = Config::get('dateHumanize.es.dayOfWeek');

        $this->setCarbonFormats();
    }

    public function parse(string $text, UserModel $user) : ?Carbon
    {
        $textClean = string_collapse_whitespace($text);

        // si no hay asunto, por defecto mandar el email dentro de x horas
        if (empty($textClean)) {
            return Carbon::now($user->timezone)
                ->addHours($user->reminder_empty_subject_skipped_at)
                ->second(0)
                ->setTimezone('UTC');
        }

        // parseo fechas con carbon
        $dateParsed = $this->dateFormatToCarbon($textClean, $user);

        // parseo de palabras a fechas
        if (is_null($dateParsed)) {
            $dateParsed = $this->wordsToCarbon($textClean, $user);
        }

        if (!is_null($dateParsed) && $dateParsed->isPast()) {
            return null;
        }

        return $dateParsed;
    }

    protected function wordsToCarbon(string $text, UserModel $user) : ?Carbon
    {
        $date = null;

        $textClean = Stringy::toLowerCase(Stringy::toAscii($text));

        // si es true, cuando una fecha es anterior a ahora, añade un año a la fecha
        $addYearWhenPast = false;

        // si es true, cuando una fecha es anterior a ahora, añade un mes a la fecha
        $addMonthWhenPast = false;

        // si es true, cuando una fecha es anterior a ahora, añade una semana a la fecha
        $addWeekWhenPast = false;

        // prepare date
        $day    = null;
        $month  = null;
        $year   = null;
        $hour   = null;
        $minute = null;
        $second = 0;

        // hora invalida
        if (preg_match($this->regex['timeInvalid'], $textClean)) {
            return null;
        }

        // hoy con solo la hora y minuto
        if (preg_match($this->regex['todayOnlyHourAndMinute'], $textClean)) {
            $day = Carbon::now($user->timezone)->day;

            $matches = matches($this->regex['todayOnlyHourAndMinute'], $textClean);
            $time    = $this->time($matches[0][2]);
            $hour    = $time['hour'];
            $minute  = $time['minute'];
        // hoy con solo la hora (y minutos opcionales)
        } elseif (preg_match($this->regex['todayOnlyHour'], $textClean)) {
            $day = Carbon::now($user->timezone)->day;

            $matches = matches($this->regex['todayOnlyHour'], $textClean);
            $time    = $this->time($matches[0][1]);
            $hour    = $time['hour'];
            if (!is_null($time['minute'])) {
                $minute = $time['minute'];
            }
        } else {
            // hora y minuto
            $matches = matches($this->regex['time'], $textClean);
            if (match_any($matches)) {
                $time   = $this->time($matches[0][2]);
                $hour   = $time['hour'];
                $minute = $time['minute'];
            }

            // parse: hoy
            if (preg_match($this->regex['today'], $textClean)) {
                $day = Carbon::now($user->timezone)->day;
                if (Carbon::now($user->timezone)->addHours($user->reminder_empty_subject_skipped_at)->isToday()) {
                    $hour = Carbon::now($user->timezone)->addHours($user->reminder_empty_subject_skipped_at)->hour;
                } else {
                    $hour   = 23;
                    $minute = 59;
                }
            // parse: mañana
            } elseif (preg_match($this->regex['dayAfterTomorrow'], $textClean)) {
                $day   = Carbon::now($user->timezone)->addDays(2)->day;
                $month = Carbon::now($user->timezone)->addDays(2)->month;
                $year  = Carbon::now($user->timezone)->addDays(2)->year;
            // parse: mañana
            } else {
                // eliminamos "por la mañana" para evitar que entre en conflicto con "mañana"
                $textCleanForRegex = preg_replace($this->regex['morning'], '', $textClean);
                if (preg_match($this->regex['tomorrow'], $textCleanForRegex)) {
                    $day   = Carbon::tomorrow($user->timezone)->day;
                    $month = Carbon::tomorrow($user->timezone)->month;
                    $year  = Carbon::tomorrow($user->timezone)->year;
                }
            }

            // parse: a las 6 de la tarde, a las 6 de la mañana
            $matches = matches($this->regex['timeWithMomentDay'], $textClean);
            if (match_any($matches)) {
                $time   = $this->time($matches[0][3], $matches[0][7]);
                $hour   = $time['hour'];
                if (!is_null($time['minute'])) {
                    $minute = $time['minute'];
                }
            // parse: a las 5, a las 18
            } else {
                $matches = matches($this->regex['timeWithoutMomentDay'], $textClean);
                if (match_any($matches)) {
                    $time   = $this->time($matches[0][2]);
                    $hour   = $time['hour'];
                    if (!is_null($time['minute'])) {
                        $minute = $time['minute'];
                    }
                // momentos del dia (tarde, noche, etc)
                } else {
                    if (preg_match($this->regex['morning'], $textClean)) {
                        $hour   = $user->reminder_morning_at_parse->hour;
                        $minute = $user->reminder_morning_at_parse->minute;
                    } elseif (preg_match($this->regex['midday'], $textClean)) {
                        $hour   = $user->reminder_midday_at_parse->hour;
                        $minute = $user->reminder_midday_at_parse->minute;
                    } elseif (preg_match($this->regex['afternoon'], $textClean)) {
                        $hour   = $user->reminder_afternoon_at_parse->hour;
                        $minute = $user->reminder_afternoon_at_parse->minute;
                    } elseif (preg_match($this->regex['night'], $textClean)) {
                        $hour   = $user->reminder_night_at_parse->hour;
                        $minute = $user->reminder_night_at_parse->minute;
                    }
                }
            }

            // dia X
            $matches = matches($this->regex['dayNumber'], $textClean);
            if (match_any($matches)) {
                $day = (int) $matches[0][2];

                // set config date past
                $addYearWhenPast  = false;
                $addMonthWhenPast = true;
                $addWeekWhenPast  = false;
            }

            // dia como numero y mes como palabra
            foreach ($this->month as $monthWord => $monthNumber) {
                $regexDayNumberAndMonthWord = $this->regexReplace($this->regex['dayNumberAndMonthWord'], $monthWord);

                $matches = matches($regexDayNumberAndMonthWord, $textClean);
                if (match_any($matches)) {
                    $day = (int) $matches[0][2];
                    break;
                }
            }

            // mes como palabra
            foreach ($this->month as $monthWord => $monthNumber) {
                if (preg_match($this->regexReplace($this->regex['month'], $monthWord), $textClean)) {
                    $month = $monthNumber;

                    // set config date past
                    $addYearWhenPast  = true;
                    $addMonthWhenPast = false;
                    $addWeekWhenPast  = false;
                    break;
                }
            }

            // dia de la semana como palabra (lunes, martes, etc)
            foreach ($this->dayOfWeek as $dayOfWeekWord => $dayOfWeekNumber) {
                if (preg_match($this->regexReplace($this->regex['dayOfWeek'], $dayOfWeekWord), $textClean)) {
                    // get day number
                    $dateDayOfWeek = Carbon::now($user->timezone)
                        ->next($dayOfWeekNumber);

                    // set values from next day
                    $day   = $dateDayOfWeek->day;
                    $month = $dateDayOfWeek->month;
                    $year  = $dateDayOfWeek->year;

                    // set config date past
                    $addYearWhenPast  = false;
                    $addMonthWhenPast = false;
                    $addWeekWhenPast  = true;
                    break;
                }
            }
        }

        // default values when not set
        if (is_null($year)) {
            $year = Carbon::now($user->timezone)->year;
        }
        if (is_null($month)) {
            $month = Carbon::now($user->timezone)->month;
        }
        if (is_null($hour)) {
            $hour = $user->reminder_morning_at_parse->hour;
            if (is_null($minute)) {
                $minute = $user->reminder_morning_at_parse->minute;
            }
        } else {
            if (is_null($minute)) {
                $minute = 0;
            }
        }

        if (!is_null($year)
            && !is_null($month)
            && !is_null($day)
            && !is_null($hour)
            && !is_null($minute)
            && !is_null($second)
        ) {
            // generate date
            $date = Carbon::create($year, $month, $day, $hour, $minute, $second, $user->timezone)->setTimezone('UTC');

            // corrige fecha para evitar que este en pasado
            if ($date->isPast()) {
                if ($addYearWhenPast) {
                    $date->addYear();
                } elseif ($addMonthWhenPast) {
                    $date->addMonth();
                } elseif ($addWeekWhenPast) {
                    $date->addWeek();
                }
            }
        }

        return $date;
    }

    protected function dateFormatToCarbon(string $text, UserModel $user) : ?Carbon
    {
        $date = null;
        foreach ($this->carbonFormats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $text, $user->timezone)->second(0);
                if ($date->isPast() && !preg_match('/(\/|\-)(Y|y)/', $format)) {
                    $date->addYear();
                }
                $date->setTimezone('UTC');
                break;
            } catch (Exception $e) {
                // nothing
            }
        }

        return $date;
    }

    protected function setCarbonFormats()
    {
        $formats = $this->config['dates'];

        // add year in format "17" and "2017"
        foreach ($formats as $format) {
            $formats[] = preg_replace(
                $this->replace['dateFormatYearShort']['search'],
                $this->replace['dateFormatYearShort']['replace'],
                $format
            );
            $formats[] = preg_replace(
                $this->replace['dateFormatYear']['search'],
                $this->replace['dateFormatYear']['replace'],
                $format
            );
        }

        // add day in format "1"
        foreach ($formats as $format) {
            $formats[] = preg_replace(
                $this->replace['dateFormatDayOneDigit']['search'],
                $this->replace['dateFormatDayOneDigit']['replace'],
                $format
            );
        }

        // add "-" format for date
        foreach ($formats as $format) {
            $formats[] = preg_replace('/\//', '-', $format);
        }

        $this->carbonFormats = array_unique($formats);
    }

    protected function time(string $time, string $momentDay = null) : array
    {
        if (preg_match($this->regex['timeUnionOperator'], $time)) {
            $timeParsed = explode($this->separator['timeUnionOperator'], $time);
        } elseif (preg_match($this->regex['timeUnionWord'], $time)) {
            $timeParsed = explode($this->separator['timeUnionWord'], $time);
        } else {
            $timeParsed[0] = (int) $time;
        }

        $timeReturn['hour']   = (int) $timeParsed[0];
        $timeReturn['minute'] = null;
        if (isset($timeParsed[1])) {
            $timeReturn['minute'] = (int) $timeParsed[1];
        }

        if (!is_null($momentDay)) {
            // si el momento del dia es de "tarde" o "noche"
            if (in_array($momentDay, $this->config['momentDayAfter12'])) {
                $timeReturn['hour'] = $timeReturn['hour'] + 12; // convierte a "formato 24 horas"
            // si el momento del dia es "mediodia"
            } elseif ($momentDay === $this->config['midday']) {
                // si la hora es menor a 8, se entiende que se refiere a una hora superior a las 12 de la mañana
                // si es mayor a 8, se considera que no hay que tocar la hora
                if ($timeReturn['hour'] < 8) {
                    $timeReturn['hour'] = $timeReturn['hour'] + 12; // convierte a "formato 24 horas"
                }
            }
        }

        return $timeReturn;
    }

    protected function regexReplace(string $regex, string $replace) : string
    {
        return str_replace('{replace}', preg_quote($replace, '/'), $regex);
    }
}
