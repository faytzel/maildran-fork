@component('mail::message')

# @lang('email.auth.register.msg1')

@lang('email.auth.register.msg3') __{{ $password }}__

@component('mail::button', ['url' => route('login', ['email' => $email])])
    @lang('email.auth.register.msg2') {{ config('app.name') }}
@endcomponent

@endcomponent
