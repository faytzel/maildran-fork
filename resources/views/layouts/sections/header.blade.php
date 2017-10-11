<nav id="header">
    <nav id="header-menu">
        <div class="left">
            <a id="header-logo" href="{{ route('home.index') }}">
                <img src="{{ asset('img/logo/white.png') }}">
                <span>{{ config('app.name') }}</span>
            </a>
        </div>
        <div class="right">
            @if (is_null($exception))
                <div id="header-menu-btn">
                    <a href="#">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                    </a>
                </div>
                <ul id="header-menu-submenu">
                    @if (Auth::guest())
                        <li>
                            <a href="{{ route('login') }}">@lang('header.login')</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}">@lang('header.register')</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('reminder.index') }}">@lang('header.reminder')</a>
                        </li>
                        <li>
                            <a href="{{ route('settings.user') }}">@lang('header.settings')</a>
                        </li>
                        <li>
                            <a href="#" onclick="App.Form.send('{{ route('logout') }}'); return false;">
                                @lang('header.logout')
                            </a>
                        </li>
                    @endif
                    <li class="text-center">
                        <a id="header-menu-btn-close" href="#"">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <span>@lang('header.close')</span>
                        </a>
                    </li>
                </ul>
            @else
                <div id="header-menu-back-home">
                    <a href="{{ route('home.index') }}">
                        @lang('header.goHome')
                    </a>
                </div>
            @endif
        </div>
        <div class="clearfix"></div>

        <div id="header-loader" class="hidden">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>
    </nav>
</nav>
