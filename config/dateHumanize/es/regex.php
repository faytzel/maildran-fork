<?php

return [

    'today'                  => '/(^|\s)hoy(\s|$)/',
    'tomorrow'               => '/(^|\s)manana(\s|$)/',
    'dayAfterTomorrow'       => '/(^|\s)pasado manana(\s|$)/',
    'morning'                => '/(^|\s)(por la|de|de la) manana(\s|$)/',
    'timeWithMomentDay'      => '/(^|\s)(a las\s)?([0-9]{1,2}((\:|\sy\s)[0-9]{1,2})?)\s'
    . '(por la|de la|de|a la|a|del|al)\s(manana|mediodia|tarde|noche)(\s|$)/',
    'timeWithoutMomentDay'   => '/(^|\s)a las ([0-9]{1,2}((\:|\sy\s)[0-9]{1,2})?)(\s|$)/',
    'midday'                 => '/(^|\s)(a|del|al) mediodia(\s|$)/',
    'afternoon'              => '/(^|\s)(por la|de la|de|a la) tarde(\s|$)/',
    'night'                  => '/(^|\s)(por la|de la|de|a la) noche(\s|$)/',
    'dayNumberAndMonthWord'  => '/(^|\s)([0-9]{1,2})\s(de\s)?({replace})(\s|$)/',
    'dayNumber'              => '/(^|\s)dia ([0-9]{1,2})(\s|$)/',
    'time'                   => '/(^|\s)([0-9]{1,2}(\:|\sy\s)[0-9]{1,2})(\s|$)/',
    'timeInvalid'            => '/(^|\s)([0-9]{1,2}\:[0-9]{1})(\s|$)/',
    'month'                  => '/(^|\s){replace}(\s|$)/',
    'dayOfWeek'              => '/(^|\s){replace}(\s|$)/',
    'timeUnionOperator'      => '/\:/',
    'timeUnionWord'          => '/\sy\s/',
    'todayOnlyHourAndMinute' => '/^(a las )?([0-9]{1,2}(\:|\sy\s)[0-9]{1,2})$/',
    'todayOnlyHour'          => '/^a las ([0-9]{1,2}((\:|\sy\s)[0-9]{1,2})?)$/',

];
