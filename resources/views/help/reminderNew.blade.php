@extends('layouts.app')

@section('content')

    <section>
        <h1>@lang('help.reminderNew.title')</h1>

        <p>@lang('help.reminderNew.msg1') <a href="{{ route('reminder.vcard') }}" target="_blank">@lang('help.reminderNew.msg2')</a>.</p>
        <p>
            @if (Auth::check())
                @lang('help.reminderNew.msg3')
                <b>{{ Auth::user()->email }}</b>
                @lang('help.reminderNew.msg18')
                <a href="mailto:{{ Auth::user()->email_reminder }}">{{ Auth::user()->email_reminder }}</a>
                (@lang('help.reminderNew.msg19') <a href="{{ route('settings.reminder') }}">@lang('help.reminderNew.msg20')</a>)
                @lang('help.reminderNew.msg4'):
            @else
                @lang('help.reminderNew.msg22'):
            @endif
        </p>
        <p>
            <ul>
                <li>
                    <b>@lang('help.reminderNew.msg5') :</b> @lang('help.reminderNew.msg6')
                    (<a href="{{ route('help.reminderDatetime') }}">@lang('help.reminderNew.msg21')</a>)
                    <div class="space-left-20 space-5">
                        <u>@lang('help.reminderNew.msg10'):</u>
                        <ul>
                            <li>@lang('help.reminderNew.msg11')</li>
                            <li>@lang('help.reminderNew.msg12')</li>
                            <li>@lang('help.reminderNew.msg13')</li>
                            <li>@lang('help.reminderNew.msg14')</li>
                            <li><i>@lang('help.reminderNew.msg15')</i></li>
                        </ul>
                    </div>
                </li>
                <li><b>@lang('help.reminderNew.msg7'):</b> @lang('help.reminderNew.msg8')</li>
            </ul>
        </p>
        <p>@lang('help.reminderNew.msg9'):</p>
        <img class="img-responsive" src="{{ asset('img/reminder-example.jpg') }}">
        <br>
        <br>
        <p>@lang('help.reminderNew.msg16').</p>
        <p>@lang('help.reminderNew.msg17').</p>
    </section>

@endsection
