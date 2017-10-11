<meta charset="utf-8">

<base href="{{ url('/') }}">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title', ViewLayout::title())</title>

<meta name="description" content="{{ ViewLayout::description() }}">

<meta name="robots" content="{{ ViewLayout::robots() }}">

<meta name="referrer" content="origin-when-cross-origin">

{{-- Open Graph --}}
<?php $openGraph = ViewLayout::openGraph(); ?>
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $openGraph->title }}">
<meta property="og:url" content="{{ $openGraph->url }}">
<meta property="og:description" content="{{ $openGraph->description }}">
<meta property="og:image" content="{{ $openGraph->image }}">
<meta property="og:site_name" content="{{ $openGraph->siteName }}">

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="{{ $openGraph->siteName }}">
<meta name="twitter:title" content="{{ $openGraph->title }}">
<meta name="twitter:description" content="{{ $openGraph->description }}">
<meta name="twitter:image:src" content="{{ $openGraph->image }}">
<meta name="twitter:domain" content="{{ $openGraph->siteName }}">

{{-- manifest --}}
<link rel="manifest" href="{{ asset('manifest.json') }}">

{{-- icon --}}
<link rel="icon" href="{{ asset('favicon.png') }}" sizes="16x16">
<link rel="icon" href="{{ asset('favicon-32.png') }}" sizes="32x32">

{{-- icon for android --}}
<link rel="icon" sizes="192x192" href="{{ asset('img/logo/192.png') }}">
<link rel="icon" sizes="128x128" href="{{ asset('img/logo/128.png') }}">

{{-- icon for ios --}}
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/logo/180.png') }}">
<link rel="apple-touch-icon" sizes="167x167" href="{{ asset('img/logo/167.png') }}">

{{-- pint tab icon safari --}}
<link rel="mask-icon" sizes="any" href="{{ asset('favicon.svg') }}" color="#2D3349">

<meta name="theme-color" content="#2D3349">

<!-- Styles -->
<link href="{{ mix('/css/app.css') }}" rel="stylesheet">

<script>
    @if (cookie_consent_accepted() && !empty(config('services.google.analytics')))
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '{{ config('services.google.analytics') }}', 'auto');
        ga('require', 'linkid', 'linkid.js');
        ga('set', 'anonymizeIp', true);
        ga('send', 'pageview');
    @endif
</script>

