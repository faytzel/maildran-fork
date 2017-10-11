@component('mail::message')

# @lang('email.reminder.remember.msg1')

__ @lang('email.reminder.remember.msg2'): __

> @text_pretty($reminder->message)

<br>

## @lang('email.reminder.remember.msg3')

@component('mail::button', ['url' => route('reminder.edit', $reminder)])
    @lang('email.reminder.remember.msg4')
@endcomponent

@endcomponent
