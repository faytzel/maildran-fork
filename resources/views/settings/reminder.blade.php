@extends('layouts.app')

@section('content')

    <h1>@lang('settings.index.title')</h1>

    @include('settings.tab')

    <h2>@lang('settings.reminder.subtitle_1')</h2>

    <form id="form-settings-reminder-email" class="form" method="PUT" action="{{ route('settings.emailReminderCode.update') }}">
        <div class="form-group">
            <p>@lang('settings.reminder.msg2').</p>
        </div>
        <div class="form-group">
            <div class="left">
                <input id="form-settings-reminder-email-field-email-code" type="text" name="email_code"
                    value="{{ Auth::user()->email_reminder_code}}" required size="45">
            </div>
            <div class="left">
                {{ '@' . Config::get('services.mailgun.receiveDomain') }}
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">
                @lang('form.button.save')
            </button>
        </div>
        <div class="form-group">
            <p>
                <i>
                    @lang('settings.reminder.msg3')
                    <a href="{{ route('reminder.vcard') }}" target="_blank">@lang('settings.reminder.msg4')</a>.
                </i>
            </p>
        </div>
    </form>

    <div class="space-40 separator"></div>

    <h2>@lang('settings.reminder.subtitle_3')</h2>

    <form id="form-settings-reminder-moment" class="form" method="PUT" action="{{ route('settings.reminderMoment.update') }}">
        <div class="form-group">
            <p>@lang('settings.reminder.msg5').</p>
            <p>@lang('settings.reminder.msg6').</p>
        </div>
        <div class="form-group">
            <label for="form-settings-reminder-moment-field-morning">@lang('form.field.morning')</label>
            <input id="form-settings-reminder-moment-field-morning" type="text" name="morning"
                class="input-time" value="@input_time(Auth::user()->reminder_morning_at)" required>
        </div>
        <div class="form-group">
            <label for="form-settings-reminder-moment-field-midday">@lang('form.field.midday')</label>
            <input id="form-settings-reminder-moment-field-midday" type="text" name="midday"
                class="input-time" value="@input_time(Auth::user()->reminder_midday_at)" required>
        </div>
        <div class="form-group">
            <label for="form-settings-reminder-moment-field-afternoon">@lang('form.field.afternoon')</label>
            <input id="form-settings-reminder-moment-field-afternoon" type="text" name="afternoon"
                class="input-time" value="@input_time(Auth::user()->reminder_afternoon_at)" required>
        </div>
        <div class="form-group">
            <label for="form-settings-reminder-moment-field-night">@lang('form.field.night')</label>
            <input id="form-settings-reminder-moment-field-night" type="text" name="night"
                class="input-time" value="@input_time(Auth::user()->reminder_night_at)" required>
        </div>
        <div class="form-group">
            <label for="form-settings-reminder-moment-field-skipped">@lang('form.field.emptySubjectSkipped')</label>
            <input id="form-settings-reminder-moment-field-skipped" type="number" min="1" max="24" name="empty_subject_skipped"
                value="{{ Auth::user()->reminder_empty_subject_skipped_at }}" required>
        </div>
        <div class="form-group">
            <button class="btn" type="submit">
                @lang('form.button.save')
            </button>
        </div>
    </form>

    <div class="space-40 separator"></div>

    <h2>@lang('settings.reminder.subtitle_2')</h2>

    <form id="form-settings-calendar" class="form">
        <div class="form-group">
            <p>@lang('settings.reminder.msg1').</p>
        </div>
        <div class="form-group">
            <input id="form-settings-calendar-field-url" type="text"
                value="{{ route('reminder.calendar', [Auth::user()->id, Auth::user()->calendar_token]) }}">
        </div>
        <div class="form-group">
            <button class="btn btn-clipboard" type="button" data-clipboard-target="#form-settings-calendar-field-url">
                <i class="fa fa-clipboard" aria-hidden="true"></i>
                @lang('form.button.copy')
            </button>
        </div>
    </form>

@endsection
