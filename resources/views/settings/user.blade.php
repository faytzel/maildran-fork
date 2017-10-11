@extends('layouts.app')

@section('content')

    <h1>@lang('settings.index.title')</h1>

    @include('settings.tab')

    <h2>@lang('settings.user.subtitle_1')</h2>

    <form id="form-settings-timezone" class="form" method="PUT" action="{{ route('settings.timezone.update') }}">
        <div class="form-group">
            <select id="form-settings-timezone-field-timezone" name="timezone" required>
                @foreach ($timezones as $timezoneValue => $timezoneText)
                    <option value="{{ $timezoneValue }}" @select_option_current($timezoneValue, Auth::user()->timezone)>
                        {{ $timezoneText }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">
                @lang('form.button.save')
            </button>
        </div>
    </form>

    <div class="space-40 separator"></div>

    <h2>@lang('settings.user.subtitle_2')</h2>

    <form id="form-settings-password" class="form" method="PUT" action="{{ route('settings.password.update') }}">
        <div class="form-group">
            <label for="form-settings-password-field-password">@lang('form.field.passwordCurrent')</label>
            <input id="form-settings-password-field-password" type="password" name="password">
        </div>
        <div class="form-group">
            <label for="form-settings-password-field-new-password">@lang('form.field.newPassword')</label>
            <input id="form-settings-password-field-new-password" type="password" name="new_password">
        </div>
        <div class="form-group">
            <label for="form-settings-password-field-new-password-confirmation">@lang('form.field.newPasswordConfirmation')</label>
            <input id="form-settings-password-field-new-password-confirmation" type="password" name="new_password_confirmation">
        </div>
        <div class="form-group">
            <button type="submit" class="btn">
                @lang('form.button.save')
            </button>
        </div>
    </form>

    <div class="space-40 separator"></div>

    <h2>@lang('settings.user.subtitle_3')</h2>

    <form id="form-settings-user-delete" class="form" method="DELETE" action="{{ route('settings.user.delete') }}">
        <div class="form-group">
            <p>@lang('settings.user.msg1').</p>
        </div>
        <div class="form-group">
            <label for="form-settings-user-delete-field-password">@lang('form.field.password')</label>
            <input id="form-settings-user-delete-field-password" type="password" name="password">
        </div>
        <div class="form-group">
            <label for="form-settings-user-delete-field-reason">@lang('form.field.reason')</label>
            <input id="form-settings-user-delete-field-reason" type="text" name="reason">
        </div>
        <div class="form-group">
            <button type="submit" class="btn" onclick="App.Settings.userDelete(this); return false;">
                @lang('form.button.userDelete')
            </button>
        </div>
    </form>

@endsection
