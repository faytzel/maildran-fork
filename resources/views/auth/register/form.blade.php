@extends('layouts.app')

@section('content')

    <h1>@lang('auth.register.title')</h1>

    <form id="form-register" class="form" method="POST" action="{{ route('register') }}">
        @form_captcha('form-register')
        <div class="form-group">
            <label for="form-register-field-email">@lang('form.field.email')</label>
            <input id="form-register-field-email" type="email" name="email" required onchange="App.Mail.check(this);">
        </div>
        <div class="form-group">
            <label class="checkbox" for="form-register-field-legal">
                <input id="form-register-field-legal" type="checkbox" name="legal" value="1" required>
                @lang('auth.register.msg1')
                <a href="{{ route('legal.tos') }}">@lang('auth.register.msg2')</a>@lang('auth.register.msg3')
                <a href="{{ route('legal.privacy') }}">@lang('auth.register.msg4')</a>
                @lang('auth.register.msg5')
                <a href="{{ route('legal.cookie') }}">@lang('auth.register.msg6')</a>
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">@lang('form.button.register')</button>
        </div>
    </form>

@endsection
