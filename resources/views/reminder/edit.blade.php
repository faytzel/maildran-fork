@extends('layouts.app')

@section('content')

    <h1>@lang('reminder.edit.title')</h1>

    <form id="form-reminder-edit" class="form" method="PUT" action="{{ route('reminder.update', [$reminder]) }}">
        @form_back()
        <div class="form-group">
            <label for="form-reminder-edit-field-schedule">@lang('form.field.schedule')</label>
            <input id="form-reminder-edit-field-schedule" name="schedule" type="text" class="input-datetime"
                value="@input_datetime($reminder->scheduled_at)" required autofocus>
        </div>
        <div class="form-group">
            <label for="form-reminder-edit-field-message">@lang('form.field.reminder')</label>
            <textarea id="form-reminder-edit-field-message" name="message"
                rows="1" cols="1">{{ $reminder->message }}</textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">
                @if ($reminder->isNotified())
                    @lang('form.button.delay')
                @else
                    @lang('form.button.save')
                @endif
            </button>
        </div>
    </form>

@endsection
