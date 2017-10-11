@extends('layouts.app')

@section('content')

    <h1>@lang('contact.new.title')</h1>

    <form id="form-contact" class="form" method="POST" action="{{ route('contact.create') }}">
        @form_captcha('form-contact')
        <div class="form-group">
            <label for="form-contact-field-name">@lang('form.field.name')</label>
            <input id="form-contact-field-name" type="text" name="name" required>
        </div>
        <div class="form-group">
            <label for="form-contact-field-email">@lang('form.field.email')</label>
            <input id="form-contact-field-email" type="email" name="email" value="{{ Request::get('email') }}">
        </div>
        <div class="form-group">
            <label for="form-contact-field-subject">@lang('form.field.subject')</label>
            <input id="form-contact-field-subject" type="text" name="subject" value="{{ Request::get('subject') }}">
        </div>
        <div class="form-group">
            <label for="form-contact-field-message">@lang('form.field.message')</label>
            <textarea name="message" rows="1" cols="1">{{ Request::get('message') }}</textarea>
        </div>
        <div class="form-group">
            <label class="checkbox" for="form-contact-field-legal">
                <input id="form-contact-field-legal" type="checkbox" name="legal" value="1" required>
                @lang('contact.new.msg1')
                <a href="{{ route('legal.tos') }}">@lang('contact.new.msg2')</a>@lang('contact.new.msg3')
                <a href="{{ route('legal.privacy') }}">@lang('contact.new.msg4')</a>
                @lang('contact.new.msg5')
                <a href="{{ route('legal.cookie') }}">@lang('contact.new.msg6')</a>
            </label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn">
                @lang('form.button.send')
            </button>
        </div>
    </form>

@endsection
