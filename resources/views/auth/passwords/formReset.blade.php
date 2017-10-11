@extends('layouts.app')

@section('content')

    <h1>@lang('auth.reset.title')</h1>

    <form id="form-reset-password" class="form" method="POST" action="{{ url('/password/email') }}">
        @form_captcha('form-reset-password')
        <div class="form-group">
            <label for="form-reset-password-field-email">@lang('form.field.email')</label>
            <input id="form-reset-password-field-email" type="email" name="email" required autofocus>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">
                @lang('form.button.resetPassword')
            </button>
        </div>
    </form>

@endsection
