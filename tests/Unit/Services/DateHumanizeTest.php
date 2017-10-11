<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use DateHumanize;
use Carbon;
use Exception;
use App\Models\UserModel;

class DateHumanizeTest extends TestCase
{
    protected $user;

    public function testParse() : void
    {
        // timezone for testing
        $timezones = [
            'UTC',
            'Australia/Lindeman',
            'Europe/Madrid',
            'Asia/Yangon',
            'Pacific/Rarotonga',
            'Europe/Vaduz',
            'America/Indiana/Petersburg',
        ];

        // create user
        $this->user = factory(UserModel::class)->create();

        // test many timezones
        foreach ($timezones as $timezone) {
            $this->user->timezone = $timezone;
            $this->runTestParse();
        }
    }

    protected function runTestParse() : void
    {
        // sin fecha
        $this->assertParseDate(
            '',
            [Carbon::now($this->user->timezone)->addHours(3)->second(0)->setTimezone('UTC')]
        );

        // para evitar confundir "mañana" y "por la mañana"
        $this->assertParseDate(
            'por la mañana',
            [
                Carbon::now($this->user->timezone)->hour(9)->minute(30)->second(0)->setTimezone('UTC'),
                null,
            ]
        );
        $this->assertParseDate(
            'mañana',
            [Carbon::tomorrow($this->user->timezone)->hour(9)->minute(30)->second(0)->setTimezone('UTC')]
        );
        $this->assertParseDate(
            'mañana por la mañana',
            [Carbon::tomorrow($this->user->timezone)->hour(9)->minute(30)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'hoy',
            [
                Carbon::now($this->user->timezone)->addHours(3)->minute(0)->second(0)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)->hour(23)->minute(59)->second(0)->setTimezone('UTC'),
            ]
        );

        $this->assertParseDate(
            'mañana a las 6 de la tarde',
            [Carbon::tomorrow($this->user->timezone)->hour(18)->minute(0)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'pasado mañana por la mañana',
            [Carbon::now($this->user->timezone)->addDays(2)->hour(9)->minute(30)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'hoy de tarde',
            [
                Carbon::now($this->user->timezone)->hour(17)->minute(0)->second(0)->setTimezone('UTC'),
                null,
            ]
        );

        $this->assertParseDate(
            'pasado mañana por la noche',
            [Carbon::now($this->user->timezone)->addDays(2)->hour(21)->minute(15)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'pasado mañana de mañana',
            [Carbon::now($this->user->timezone)->addDays(2)->hour(9)->minute(30)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'hoy al mediodía',
            [
                Carbon::now($this->user->timezone)->hour(12)->minute(0)->second(0)->setTimezone('UTC'),
                null,
            ]
        );

        $this->assertParseDate(
            'pasado mañana de noche',
            [Carbon::now($this->user->timezone)->addDays(2)->hour(21)->minute(15)->second(0)->setTimezone('UTC')]
        );

        // el ->month() debe ir al final, para evitar que al cambiar de 31 de abril a febrero, carbon te cambia a marzo
        $this->assertParseDate(
            '22 de junio',
            [
                Carbon::now($this->user->timezone)
                    ->day(22)->hour(9)->minute(30)->second(0)->month(6)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(22)->hour(9)->minute(30)->second(0)->month(6)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            'mañana a las 14 del mediodía',
            [Carbon::tomorrow($this->user->timezone)->hour(14)->minute(0)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'mañana a las 11 a mediodía',
            [Carbon::tomorrow($this->user->timezone)->hour(11)->minute(0)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'mañana a las 12 a mediodía',
            [Carbon::tomorrow($this->user->timezone)->hour(12)->minute(0)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'mañana a las 2 del mediodía',
            [Carbon::tomorrow($this->user->timezone)->hour(14)->minute(0)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            '10 de febrero a las 4 de la tarde',
            [
                Carbon::now($this->user->timezone)
                    ->day(10)->hour(16)->minute(0)->second(0)->month(2)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(10)->hour(16)->minute(0)->second(0)->month(2)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            '4 enero por la noche',
            [
                Carbon::now($this->user->timezone)
                    ->day(4)->hour(21)->minute(15)->second(0)->month(1)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(4)->hour(21)->minute(15)->second(0)->month(1)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            'dia 1',
            [
                Carbon::now($this->user->timezone)->day(1)->hour(9)->minute(30)->second(0)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(1)->hour(9)->minute(30)->second(0)->setTimezone('UTC')->addMonth(),
            ]
        );

        $this->assertParseDate(
            'dia 15 de junio a las 10',
            [
                Carbon::now($this->user->timezone)
                    ->day(15)->hour(10)->minute(0)->second(0)->month(6)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(15)->hour(10)->minute(0)->second(0)->month(6)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            'dia 15 de junio a las 10:15',
            [
                Carbon::now($this->user->timezone)
                    ->day(15)->hour(10)->minute(15)->second(0)->month(6)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(15)->hour(10)->minute(15)->second(0)->month(6)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            'dia 15 de junio a las 10 y 8',
            [
                Carbon::now($this->user->timezone)
                    ->day(15)->hour(10)->minute(8)->second(0)->month(6)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(15)->hour(10)->minute(8)->second(0)->month(6)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            'dia 22 a las 19',
            [
                Carbon::now($this->user->timezone)->day(22)->hour(19)->minute(0)->second(0)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(22)->hour(19)->minute(0)->second(0)->setTimezone('UTC')->addMonth(),
            ]
        );

        $this->assertParseDate(
            'lunes',
            [
                Carbon::now($this->user->timezone)
                    ->next(Carbon::MONDAY)->hour(9)->minute(30)->second(0)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->next(Carbon::MONDAY)->hour(9)->minute(30)->second(0)->setTimezone('UTC')->addWeek(),
            ]
        );

        $this->assertParseDate(
            'domingo por la tarde',
            [
                Carbon::now($this->user->timezone)
                    ->next(Carbon::SUNDAY)->hour(17)->minute(0)->second(0)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->next(Carbon::SUNDAY)->hour(17)->minute(0)->second(0)->setTimezone('UTC')->addWeek(),
            ]
        );

        $this->assertParseDate(
            'domingo a las 8 de la noche',
            [
                Carbon::now($this->user->timezone)
                    ->next(Carbon::SUNDAY)->hour(20)->minute(0)->second(0)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->next(Carbon::SUNDAY)->hour(20)->minute(0)->second(0)->setTimezone('UTC')->addWeek(),
            ]
        );

        $this->assertParseDate(
            'lunes a las 4:15 de la mañana',
            [
                Carbon::now($this->user->timezone)
                    ->next(Carbon::MONDAY)->hour(4)->minute(15)->second(0)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->next(Carbon::MONDAY)->hour(4)->minute(15)->second(0)->setTimezone('UTC')->addWeek(),
            ]
        );

        $this->assertParseDate(
            'pasado mañana a las 4:15 de la tarde',
            [Carbon::now($this->user->timezone)->addDays(2)->hour(16)->minute(15)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'mañana a las 15:45',
            [Carbon::tomorrow($this->user->timezone)->hour(15)->minute(45)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'mañana a las 1:45',
            [Carbon::tomorrow($this->user->timezone)->hour(1)->minute(45)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'mañana a las 5:4',
            [null]
        );

        $this->assertParseDate(
            'mañana a las 5 y 4',
            [Carbon::tomorrow($this->user->timezone)->hour(5)->minute(4)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            '1/4/2017',
            [
                Carbon::now($this->user->timezone)->day(1)->second(0)->month(4)->setTimezone('UTC'),
                null,
            ]
        );

        $this->assertParseDate(
            '1/4/30',
            [
                Carbon::now($this->user->timezone)->year(2030)->day(1)->second(0)->month(4)->setTimezone('UTC'),
            ]
        );

        $this->assertParseDate(
            '1/2',
            [
                Carbon::now($this->user->timezone)->day(1)->second(0)->month(2)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)->day(1)->second(0)->month(2)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            '01/2',
            [
                Carbon::now($this->user->timezone)->day(1)->second(0)->month(2)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)->day(1)->second(0)->month(2)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            '14/4 15:15',
            [
                Carbon::now($this->user->timezone)
                    ->day(14)->hour(15)->minute(15)->second(0)->month(4)->setTimezone('UTC'),
                Carbon::now($this->user->timezone)
                    ->day(14)->hour(15)->minute(15)->second(0)->month(4)->setTimezone('UTC')->addYear(),
            ]
        );

        $this->assertParseDate(
            '14/4 15:5',
            [null]
        );

        $this->assertParseDate(
            'mañana a las 8 y 5',
            [
                Carbon::tomorrow($this->user->timezone)->hour(8)->minute(5)->second(0)->setTimezone('UTC'),
            ]
        );

        $this->assertParseDate(
            'mañana a las 8 y 20',
            [
                Carbon::tomorrow($this->user->timezone)->hour(8)->minute(20)->second(0)->setTimezone('UTC'),
            ]
        );

        $this->assertParseDate(
            'mañana a las 7 y 25 de la noche',
            [
                Carbon::tomorrow($this->user->timezone)->hour(19)->minute(25)->second(0)->setTimezone('UTC'),
            ]
        );

        $this->assertParseDate(
            'mañana 11:37',
            [
                Carbon::tomorrow($this->user->timezone)->hour(11)->minute(37)->second(0)->setTimezone('UTC'),
            ]
        );

        $this->assertParseDate(
            '23:59',
            [Carbon::now($this->user->timezone)->hour(23)->minute(59)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'a las 23:59',
            [Carbon::now($this->user->timezone)->hour(23)->minute(59)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            'a las 23',
            [
                Carbon::now($this->user->timezone)->hour(23)->minute(0)->second(0)->setTimezone('UTC'),
                null,
            ]
        );

        $this->assertParseDate(
            'a las 23 y 59',
            [Carbon::now($this->user->timezone)->hour(23)->minute(59)->second(0)->setTimezone('UTC')]
        );

        $this->assertParseDate(
            '23',
            [null]
        );
    }

    protected function assertParseDate(string $text, array $datesExpected) : void
    {
        $success     = false;
        $datesFailed = [];

        if (count($datesExpected) == 0) {
            throw new Exception('assertParseDate -> datesExpected is empty');
        }

        $date = DateHumanize::parse($text, $this->user);

        // si una fecha es valida, se da por bueno
        // ya que un mismo $text puede tener variaciones de fechas segun la hora
        foreach ($datesExpected as $dateExpected) {
            if (!is_null($date) && !is_null($dateExpected)) {
                if ($date->eq($dateExpected) && $date->tzName == $dateExpected->tzName) {
                    $success = true;
                    break;
                } else {
                    $datesFailed[] = [
                        '(' . $this->user->timezone . ') Obtenida: ' . $date . ' (' . $date->tzName . ') != Esperada: '
                            . $dateExpected . ' (' . $dateExpected->tzName . ')'
                    ];
                }
            } else {
                if ($date === $dateExpected) {
                    $success = true;
                    break;
                } else {
                    $datesFailed[] = [
                        '(' . $this->user->timezone . ') Obtenida: ' . $date . ' != Esperada: ' . $dateExpected
                    ];
                }
            }
        }

        if ($success) {
            $this->assertTrue(true);
        } else {
            throw new Exception($text . ' -> ' . json_encode($datesFailed));
        }
    }
}
