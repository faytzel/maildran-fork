@extends('layouts.app')

@section('content')

    <section>
        <h1>@lang('help.workflow.title')</h1>

        <p>@lang('help.workflow.msg1'):</p>
        <ul>
            <li>
                <a href="{{ asset('workflow/Write Reminder - MailDran.wflow') }}" rel="nofollow" target="_blank">
                    @lang('help.workflow.msg2')
                </a>
            </li>
            <li>
                <a href="{{ asset('workflow/Share URL - MailDran.wflow') }}" rel="nofollow" target="_blank">
                    @lang('help.workflow.msg3')
                </a>
            </li>
            <li>
                <a href="{{ asset('workflow/Share Text - MailDran.wflow') }}" rel="nofollow" target="_blank">
                    @lang('help.workflow.msg4')
                </a>
            </li>
        </ul>
        <p>
            @lang('help.workflow.msg5')
            <a href="https://itunes.apple.com/es/app/workflow-powerful-automation-made-simple/id915249334" rel="nofollow"
                target="_blank">@lang('help.workflow.msg6')</a>.
        </p>
    </section>

@endsection
