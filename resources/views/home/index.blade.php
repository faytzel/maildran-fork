@extends('layouts.app')

@section('content')

    <section id="home">
        <div id="home-header">
            <div id="home-header-image">
                <img src="{{ asset('img/home-header.png') }}">
            </div>
            <div id="home-header-title">
                <h1>@lang('home.title')</h1>
            </div>
            <div class="clearfix"></div>
            <div id="home-header-background"></div>
        </div>

        <p>@lang('home.msg1').</p>
        <p>@lang('home.msg2').</p>

        <div class="space-40"></div>

        <h2>@lang('home.msg3')</h2>
        <div class="space-20"></div>
        <div id="features">
            <div class="feature">
                <div class="feature-icon"><i class="fa fa-envelope-o"></i></div>
                <div class="feature-title">@lang('home.msg4')</div>
                <p class="feature-description">@lang('home.msg5')</p>
            </div>
            <div class="feature">
                <div class="feature-icon"><i class="fa fa-pencil"></i></div>
                <div class="feature-title">@lang('home.msg6')</div>
                <p class="feature-description">@lang('home.msg7')</p>
            </div>
            <div class="feature">
                <div class="feature-icon"><i class="fa fa-paper-plane"></i></div>
                <div class="feature-title">@lang('home.msg8')</div>
                <p class="feature-description">@lang('home.msg9')</p>
            </div>
            <div class="feature">
                <div class="feature-icon"><i class="fa fa-check-square-o"></i></div>
                <div class="feature-title">@lang('home.msg10')</div>
                <p class="feature-description">@lang('home.msg11')</p>
            </div>
        </div>

        <div class="space-40"></div>

        <div id="home-form">
            <h2>@lang('home.msg12')</h2>

            <form id="form-register" class="form" method="POST" action="{{ route('register') }}">
                @form_captcha('form-register')
                <div class="form-group">
                    <input id="form-register-field-email" type="email" name="email" placeholder="@lang('form.field.email')"
                        required onchange="App.Mail.check(this);">
                    <button type="submit" class="btn">@lang('form.button.register')</button>
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
            </form>
        </div>
        <div id="subscribe">
            <p>@lang('home.msg13')</p>
            <p class="space-20">
                <a id="subscribe-telegram" href="https://t.me" class="btn" target="_blank">
                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                    @lang('home.msg14')
                </a>
            </p>
            <p>@lang('home.msg15')</p>
            <p>
                <a id="subscribe-newsletter" href="http://example.com" class="btn" target="_blank">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    @lang('home.msg16')
                </a>
            </p>
        </div>
    </section>

@endsection
