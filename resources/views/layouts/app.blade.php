<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    @if (isset($settings['default_bg_color']))
        <style>
            :root {
                --default-background: {{ $settings['default_bg_color'] }};
            }
        </style>
    @endif
</head>

<body class="h-full">
    <main>
        @yield('content')
    </main>
    @yield('scripts')
</body>

</html>
