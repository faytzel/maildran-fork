@extends('layouts.app')

@section('content')

    <section>
        <h1>@lang('openMetrics.index.title')</h1>

        <ul>
            <li>
                <b>@lang('openMetrics.index.msg1'):</b> {{ $stats['users'] }}
            </li>
            <li>
                <b>@lang('openMetrics.index.msg2'):</b> {{ $stats['reminders'] }}
            </li>
        </ul>
    </section>

@endsection
