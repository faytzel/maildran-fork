@component('mail::message')

# @lang('email.reminder.empty.msg1')

__ @lang('email.reminder.empty.msg2'): __
@if ($mail['scheduled_at_raw'] == '')
<i>@lang('email.reminder.empty.msg4')</i>
@else
{{ $mail['scheduled_at_raw'] }}
@endif

__ @lang('email.reminder.empty.msg3'): __ <i>@lang('email.reminder.empty.msg4')</i>

@endcomponent
