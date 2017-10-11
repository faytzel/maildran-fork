@component('mail::message')

# @lang('email.auth.reset.msg1')

@component('mail::button', ['url' => route('password.reset', $token)])
    @lang('email.auth.reset.msg2')
@endcomponent

@endcomponent
