@component('mail::message')

# @lang('email.reminder.dateInvalid.msg1')

__ @lang('email.reminder.dateInvalid.msg3'): __ {{ $mail['scheduled_at_raw'] }}

__ @lang('email.reminder.dateInvalid.msg4'): __

> @text_pretty($mail['message'])

<br>

@lang('email.reminder.dateInvalid.msg2') <a href="{{ route('help.reminderDatetime') }}">@lang('email.reminder.dateInvalid.msg9')</a>.

@component('mail::button', [
    'url' => 'mailto:' . $user->email_reminder
            . '?subject=' . $mail['scheduled_at_raw']
            . '&body=' . $mail['message']
])
    @lang('email.reminder.dateInvalid.msg10')
@endcomponent

__ @lang('email.reminder.dateInvalid.msg5') __
<a href="{{ route('contact.new', [
    'email'   => $mail['email'],
    'subject' => trans('email.reminder.dateInvalid.msg7'),
    'message' => trans('email.reminder.dateInvalid.msg8', ['subject' => $mail['scheduled_at_raw']])
    ]) }}">@lang('email.reminder.dateInvalid.msg6')</a>

@endcomponent
