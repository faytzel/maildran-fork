@extends('layouts.app')

@section('content')

    <section>
        <h1>@lang('help.reminderDatetime.title')</h1>

        <p>@lang('help.reminderDatetime.msg1'):</p>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>@lang('help.reminderDatetime.msg2')</th>
                        <th>@lang('help.reminderDatetime.msg2')</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b><i>Sin asunto</i></b></td>
                        <td>Dentro de 3 horas *</td>
                    </tr>
                    <tr>
                        <td><b>1/4/2017</b></td>
                        <td>1 de abril de 2017 con la hora actual</td>
                    </tr>
                    <tr>
                        <td><b>11/5/17</b></td>
                        <td>11 de mayo de 2017 con la hora actual</td>
                    </tr>
                    <tr>
                        <td><b>14/4 15:15</b></td>
                        <td>El próximo 14 de abril a las 15:15</td>
                    </tr>
                    <tr>
                        <td><b>15:15</b></td>
                        <td>Hoy a las 15:15</td>
                    </tr>
                    <tr>
                        <td><b>a las 23</b></td>
                        <td>Hoy a las 23:00</td>
                    </tr>
                    <tr>
                        <td><b>a las 10 y 5</b></td>
                        <td>Hoy a las 10:05</td>
                    </tr>
                    <tr>
                        <td><b>por la mañana</b></td>
                        <td>Hoy a las 09:00 *</td>
                    </tr>
                    <tr>
                        <td><b>mañana</b></td>
                        <td>Mañana a las 09:00 *</td>
                    </tr>
                    <tr>
                        <td><b>mañana por la mañana</b></td>
                        <td>Mañana a las 09:00 *</td>
                    </tr>
                    <tr>
                        <td><b>hoy</b></td>
                        <td>Hoy dentro de 3 horas *</td>
                    </tr>
                    <tr>
                        <td><b>hoy a mediodía</b></td>
                        <td>Hoy a las 12:00 *</td>
                    </tr>
                    <tr>
                        <td><b>hoy por la tarde</b></td>
                        <td>Hoy a las 17:00 *</td>
                    </tr>
                    <tr>
                        <td><b>mañana a las 6 de la tarde</b></td>
                        <td>Mañana a las 18:00</td>
                    </tr>
                    <tr>
                        <td><b>mañana a las 7 y 25 de la noche</b></td>
                        <td>Mañana a las 19:25</td>
                    </tr>
                    <tr>
                        <td><b>mañana 11:37</b></td>
                        <td>Mañana a las 11:37</td>
                    </tr>
                    <tr>
                        <td><b>pasado mañana por la mañana</b></td>
                        <td>Pasado mañana a las 09:00 *</td>
                    </tr>
                    <tr>
                        <td><b>pasado mañana a las 4:15 de la tarde</b></td>
                        <td>Pasado mañana a las 16:15</td>
                    </tr>
                    <tr>
                        <td><b>pasado mañana por la noche</b></td>
                        <td>Pasado mañana a las 21:00 *</td>
                    </tr>
                    <tr>
                        <td><b>22 de septiembre</b></td>
                        <td>El próximo 22 de septiembre a las 09:00</td>
                    </tr>
                    <tr>
                        <td><b>15 de febrero a las 4 de la tarde</b></td>
                        <td>El próximo 15 de febrero a las 16:00</td>
                    </tr>
                    <tr>
                        <td><b>4 enero por la noche</b></td>
                        <td>El próximo 4 de enero a las 21:00 *</td>
                    </tr>
                    <tr>
                        <td><b>dia 15</b></td>
                        <td>El próximo día 15 a las 09:00</td>
                    </tr>
                    <tr>
                        <td><b>dia 22 de octubre a las 10</b></td>
                        <td>El próximo 22 de octubre a las 10:00</td>
                    </tr>
                    <tr>
                        <td><b>lúnes</b></td>
                        <td>El próximo lúnes a las 09:00 *</td>
                    </tr>
                    <tr>
                        <td><b>domingo a las 8 de la noche</b></td>
                        <td>El próximo domingo a las 20:00 *</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="space-10">
            <small>
                <i>* @lang('help.reminderDatetime.msg4').</i>
            </small>
        </p>
    </section>

@endsection
