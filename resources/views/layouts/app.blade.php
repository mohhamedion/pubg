<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <base href="{{ config('app.base_url') }}">
    <meta charset="utf-8">

    <title>@yield('title', trans('labels.project_title'))</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="application-name" content="NewApp Panel">
    <meta name="description" content="NewApp - мобильный заработок на установке приложений.">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <meta name="theme-color" content="#24dc97">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('Icon-App-180x180.png') }}">
    <link rel="icon" type="image/ico" sizes="32x32" href="{{ asset('logo_x16_ico_Tw1_icon.ico') }}">
    <link rel="icon" type="image/ico" sizes="16x16" href="{{ asset('logo_x16_ico_Tw1_icon.ico') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">

    <link rel="apple-touch-icon" href="{{ asset('Icon-App-120x120.png') }}"> {{-- 120px--}}
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('Icon-App-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('Icon-App-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('Icon-App-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('Icon-App-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('Icon-App-180x180.png') }}">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="{{ asset('/fonts/SanFrancisco/stylesheet.css') }}"> -->

    <link rel="stylesheet" href="{{ mix('css/vendor.css') }}"/>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"/>

    @stack('styles')
    @include('partials._support-scripts')
</head>
<body class="{{ $theme }}">

@include('partials._header')

@include('partials._navbar')

<div class="content{{--{{ request()->url() === route('home') && $is_manager ? '--}} home-content{{--' : '' }}{{ $notificationActive ? ' has-notification' : '' }}
@if($collapsedMenu) collapsed @endif--}}">
    @yield('content')
</div>

{{--@if(app()->environment('production') && $is_manager) @include('partials._jivosite') @endif--}}
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ mix('js/main.js') }}"></script>

@stack('scripts')
</body>
</html>