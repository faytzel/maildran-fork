<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include('layouts.sections.head')
    </head>
    <body>
        <div id="app">
            @include('layouts.sections.env')
            @include('layouts.sections.header')
            <div id="content">
                @yield('content')
            </div>
            @include('layouts.sections.alert')
        </div>

        @include('layouts.sections.footer')
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
