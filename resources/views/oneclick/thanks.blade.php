<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__("oneclick.og.title")}}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png?v=2">
    <link rel="manifest" href="/images/favicon/site.webmanifest?v=2">
    <link rel="mask-icon" href="/images/favicon/safari-pinned-tab.svg?v=2" color="#ffff00">
    <link rel="shortcut icon" href="/images/favicon/favicon.ico?v=2">
    <meta name="msapplication-TileColor" content="#ff00ff">
    <meta name="msapplication-config" content="/images/favicon/browserconfig.xml?v=2">
    <meta name="theme-color" content="#ffffff">
    @vite(["resources/css/app.scss"])
</head>
<body>
    <div class="goat-oneclick-thanks h-screen flex justify-center items-center bg-accent">
        <div class="goat-oneclick-thanks__container max-w-[793px] mx-auto px-4">
            {!!
                $oneclick->successmessage[app()->getLocale()]
            !!}
        </div>
    </div>
</body>
</html>
