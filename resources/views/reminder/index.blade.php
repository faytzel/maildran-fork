@extends('layouts.app')

@section('content')

    <div class="title-btn">
        <h1>@lang('reminder.index.title')</h1>
        <a href="{{ route('help.reminderNew')}}" class="btn">@lang('reminder.index.msg4')</a>
        <div class="clearfix"></div>
    </div>

    <div class="tabs">
        <ul>
            <li class="@tab_active('reminder.index')">
                <a href="{{ route('reminder.index')}}">@lang('reminder.tab.msg1')</a>
            </li>
            <li class="@tab_active('reminder.notified')">
                <a href="{{ route('reminder.notified')}}">@lang('reminder.tab.msg2')</a>
            </li>
        </ul>
    </div>

    <div>
        @forelse ($reminders as $reminder)
            <div class="reminder">
                <div class="reminder-message">
                    @text_pretty($reminder->message)
                </div>
                <footer class="reminder-footer">
                    <ul class="left">
                        @if ($reminder->isNotified())
                            <li class="reminder-notified-at">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                @lang('reminder.index.msg2')
                                @datetime($reminder->notified_at)
                            </li>
                        @else
                            <li class="reminder-scheduled-at">
                                <i class="fa fa-bell-slash-o" aria-hidden="true"></i>
                                @lang('reminder.index.msg3')
                                @datetime($reminder->scheduled_at)
                            </li>
                        @endif
                    </ul>
                    <ul class="right">
                        @if ($reminder->isNotified())
                            <li class="reminder-delay">
                                <a href="{{ route('reminder.edit', $reminder) }}">
                                    @lang('reminder.index.msg7')
                                </a>
                            </li>
                        @else
                            <li class="reminder-edit">
                                <a href="{{ route('reminder.edit', $reminder) }}">
                                    @lang('reminder.index.msg6')
                                </a>
                            </li>
                        @endif
                        <li class="reminder-delete">
                            <a href="#" onclick="App.Reminder.delete('{{ route('reminder.delete', $reminder) }}');">
                                @lang('reminder.index.msg1')
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </footer>
            </div>
        @empty
            <div class="list-empty">
                @if (Route::currentRouteNamed('reminder.index'))
                    @lang('reminder.index.msg5')
                @else
                    @lang('reminder.index.msg8')
                @endif
            </div>
        @endforelse
    </div>
    {{ $reminders->links() }}

@endsection
