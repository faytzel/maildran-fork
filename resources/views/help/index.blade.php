@extends('layouts.app')

@section('content')

    <section>
        <h1>@lang('help.index.title')</h1>

        <p>@lang('help.index.msg4').</p>
        <ul>
            <li>
                <a href="{{ route('help.reminderNew') }}">@lang('help.index.msg1')</a>
            </li>
            <li>
                <a href="{{ route('help.reminderDatetime') }}">@lang('help.index.msg2')</a>
            </li>
            <li>
                <a href="{{ route('help.bookmark') }}">@lang('help.index.msg7')</a>
            </li>
            <li>
                <a href="{{ route('help.workflow') }}">@lang('help.index.msg3')</a>
            </li>
        </ul>
        <p>
            @lang('help.index.msg5'),
            <a href="{{ route('contact.new') }}">@lang('help.index.msg6')</a>.
        </p>
    </section>

@endsection
