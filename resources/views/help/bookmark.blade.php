@extends('layouts.app')

@section('content')

    <section>
        <h1>@lang('help.bookmark.title')</h1>

        <p>@lang('help.bookmark.msg1').</p>
        @if (!is_null($bookmark))
            <p>
                <a href="{{ $bookmark }}" class="btn btn-bookmark" onclick="return false;">
                    @lang('help.bookmark.msg2')
                </a>
            </p>
        @else
            <div class="box-info">
                @lang('help.bookmark.msg3')
            </div>
        @endif

        <p>@lang('help.bookmark.msg4'):</p>
        @if (!is_null($bookmark))
            <textarea id="bookmark-code" class="box-readonly" rows="1" cols="1" readonly>{{ $bookmark }}</textarea>
            <button class="btn btn-clipboard" type="button" data-clipboard-target="#bookmark-code">
                <i class="fa fa-clipboard" aria-hidden="true"></i>
                @lang('form.button.copy')
            </button>
        @else
            <div class="box-info">
                @lang('help.bookmark.msg5')
            </div>
        @endif
    </section>

@endsection
