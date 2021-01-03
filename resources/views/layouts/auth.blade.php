<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <base href="{{ config('app.base_url') }}">
    <meta charset="utf-8">

    <title>@yield('title', config('app.name'))</title>

    <meta property="og:image" content="{{ asset('newlogo.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="application-name" content="TraffApp Panel">
    <meta name="description" content="Traffapp - Android/iOS app promotion.">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <meta name="theme-color" content="#24dc97">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('Icon-App-180x180.png') }}">
    <link rel="icon" type="image/ico" sizes="32x32" href="{{ asset('logo_x16_ico_Tw1_icon.ico') }}">
    <link rel="icon" type="image/ico" sizes="16x16" href="{{ asset('logo_x16_ico_Tw1_icon.ico') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">

    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}"> {{-- 120px--}}
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('Icon-App-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('Icon-App-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('Icon-App-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('Icon-App-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('Icon-App-180x180.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('Icon-App-180x180.png') }}">

    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="NewApp Panel">
    <meta property="og:description" content="NewApp - Android/iOS app promotion.">

    {{-- Interkassa payment service requires verification by special key as meta tag --}}
    <meta name="interkassa-verification" content="{{ env('INTERKASSA_VERIFICATION') }}"/>

    <link rel="stylesheet" href="{{ mix('css/auth.css') }}"/>
</head>
<body>
<div class="auth auth-layout">
    <div class="auth-logo">
        <a href="{{ route('home') }}" class="block-link">
            <img src="{{ asset('images/logo_text-x1024.png') }}" style="width: 171px" alt="Mafia"/>
        </a>
    </div>
    <div class="auth-content">
        @yield('content')
    </div>
    <footer>
        <div class="socials">
            <ul>
                <li>
                    <a href="tel:+380970446004">
                        <i class="socials-item phone"></i>
                    </a>
                </li>
                <li>
                    <a href="http://t.me/mafia" target="__blank">
                        <i class="socials-item telegram"></i>
                    </a>
                </li>
                <li>
                    <a href="skype:mafia?add">
                        <i class="socials-item skype"></i>
                    </a>
                </li>
                <li>
                    <a href="mailto:support@tmafia.com">
                        <i class="socials-item message"></i>
                    </a>
                </li>
            </ul>
        </div>
        <p class="copyright">© {{ Carbon\Carbon::now()->year . ' ' . config('app.name') }}</p>
    </footer>
</div>

{{--@if(app()->environment('production')) @include('partials._jivosite') @endif--}}
</body>
</html>
