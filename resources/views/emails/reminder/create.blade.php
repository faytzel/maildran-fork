@component('mail::message')

# @lang('email.reminder.create.msg1')

@lang('email.reminder.create.msg2'):

> @text_pretty($reminder->message)

<br>

@lang('email.reminder.create.msg3') __ @datetime($reminder->scheduled_at, $reminder->user) __

__ @lang('email.reminder.create.msg4') __
<a href="{{ route('contact.new', [
    'email'   => $reminder->user->email,
    'subject' => trans('email.reminder.create.msg6'),
    'message' => trans('email.reminder.create.msg7', ['subject' => $reminder->scheduled_at_raw])
    ]) }}">@lang('email.reminder.create.msg5')</a>

@endcomponent
