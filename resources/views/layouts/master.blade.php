<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @include('layouts.head')
    @yield('css')
    @yield('style')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @include('layouts.header')
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('backend/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
        </div>
        @yield('content')
    </div>
    @include('layouts.sidebar')
    @include('layouts.footer')
    @yield('script')
</body>
</html>
