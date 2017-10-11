@extends('layouts.app')

@section('content')

    <h1>@lang('auth.login.title')</h1>

    <form id="form-login" class="form" method="POST" action="{{ route('login') }}">
        <div class="form-group">
            <label for="form-login-field-email">@lang('form.field.email')</label>
            <input id="form-login-field-email" type="email" name="email" value="{{ Request::get('email') }}" required @unless(Request::has('email')) autofocus @endunless>
        </div>
        <div class="form-group">
            <label for="form-login-field-password">@lang('form.field.password')</label>
            <input id="form-login-field-password" type="password" name="password" required
                @if (Request::has('email')) autofocus placeholder="@lang('auth.login.msg3')" @endif>
        </div>
        <div class="form-group">
            <label class="checkbox" for="form-login-field-remember">
                <input id="form-login-field-remember" type="checkbox" name="remember" value="1">
                @lang('auth.login.msg2')
            </label>
        </div>
        <div class="form-group">
            <a href="{{ route('password.request') }}">@lang('auth.login.msg1')</a>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">
                @lang('form.button.login')
            </button>
        </div>
    </form>

@endsection
