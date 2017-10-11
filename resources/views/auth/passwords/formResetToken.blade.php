@extends('layouts.app')

@section('content')

    <h1>@lang('auth.resetToken.title')</h1>

    <form id="form-reset-password-token" class="form" method="POST" action="{{ action('Auth\ResetPasswordController@reset') }}">
        @form_captcha('form-reset-password-token')
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="form-reset-password-token-field-email">@lang('form.field.email')</label>
            <input id="form-reset-password-token-field-email" type="email" name="email" required autofocus>
        </div>
        <div class="form-group">
            <label for="form-reset-password-token-field-password">@lang('form.field.newPassword')</label>
            <input id="form-reset-password-token-field-password" type="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="form-reset-password-token-field-password-confirm">@lang('form.field.newPasswordConfirmation')</label>
            <input id="form-reset-password-token-field-password-confirm" type="password" name="password_confirmation" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">@lang('form.button.changePassword')</button>
        </div>
    </form>

@endsection
