@component('mail::message')

# @lang('email.contact.create.msg1')

__ @lang('email.contact.create.msg3'): __ {{ $name }}

__ @lang('email.contact.create.msg4'): __ {{ $email }}

__ @lang('email.contact.create.msg2'): __ {{ $subject }}

__ @lang('email.contact.create.msg5'): __

> @text_pretty($message)

@endcomponent
