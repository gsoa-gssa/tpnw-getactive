@php
    $locale = app()->getLocale();
@endphp
<!DOCTYPE html>
<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Primary Meta Tags -->
    <title>{{__("frontend.og.title")}}</title>
    <meta name="title" content="{{__("frontend.og.title")}}" />
    <meta name="description" content="{{__("frontend.og.description")}}" />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{url("")}}" />
    <meta property="og:title" content="{{__("frontend.og.title")}}" />
    <meta property="og:description" content="{{__("frontend.og.description")}}" />
    <meta property="og:image" content="{{url("images/og/og_{$locale}.png")}}" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="{{url("")}}" />
    <meta property="twitter:title" content="{{__("frontend.og.title")}}" />
    <meta property="twitter:description" content="{{__("frontend.og.description")}}" />
    <meta property="twitter:image" content="{{url("images/og/og_{$locale}.png")}}" />

    <!-- Meta Tags Generated with https://metatags.io -->

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png?v=2">
    <link rel="manifest" href="/images/favicon/site.webmanifest?v=2">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg?v=2" color="#ffff00">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico?v=2">
    <meta name="msapplication-TileColor" content="#ff00ff">
    <meta name="msapplication-config" content="/images/favicon/browserconfig.xml?v=2">
    <meta name="theme-color" content="#ffffff">

    @vite("resources/css/app.scss")
    @livewireStyles

    <!--
    /**
    * @license
    * MyFonts Webfont Build ID 793130
    *
    * The fonts listed in this notice are subject to the End User License
    * Agreement(s) entered into by the website owner. All other parties are
    * explicitly restricted from using the Licensed Webfonts(s).
    *
    * You may obtain a valid license from one of MyFonts official sites.
    * http://www.fonts.com
    * http://www.myfonts.com
    * http://www.linotype.com
    *
    */
    -->
</head>
<body>
    <main>
        @if ($header)
        <div class="tpnw-getactive-header bg-accent">
            <div class="tpnw-getactive-header__inner px-4 pt-8 md:pt-12 lg:pt-20 pb-16 md:pb-20 lg:pb-28  w-fit mx-auto max-w-7xl sm:px-6 lg:px-8 py-6">
                <x-petition-icon class="max-w-[480px] w-full mb-2 mx-auto" />
                <h2 class="text-center text-xl md:text-2xl lg:text-3xl">{{__("visual.subtitle")}}</h2>
                <h1 class="tpnw-title text-center text-5xl md:text-6xl lg:text-7xl">{{__("visual.title")}}</h1>
            </div>
        </div>
        @endif
        {{ $slot }}
    </main>
    <!-- Matomo -->
    <script>
    var _paq = window._paq = window._paq || [];
    /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
        var u="//web-statistik.gsoa.ch/matomo/";
        _paq.push(['setTrackerUrl', u+'matomo.php']);
        _paq.push(['setSiteId', '9']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
    })();
    </script>
    <!-- End Matomo Code -->
    @vite("resources/js/app.js")
    @livewireScripts
</body>
