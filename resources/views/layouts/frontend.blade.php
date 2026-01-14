<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Admin Dashboard') }}</title>
        {{-- env('SEO_KEYWORDS') --}}

        <link rel="icon" type="image/png" href="{{ asset($settings['favicon'] ?? 'images/favicon.png') }}">

        <!-- SEO -->
        <meta name="title" content="{{ $settings['seo_title'] ?? config('app.name') }}">
        <meta name="description" content="{{ $settings['seo_content'] ?? '' }}">
        <meta name="keywords" content="{{ env('SEO_KEYWORDS', 'Admin Dashboard') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Link Swiper's CSS -->
        <link rel="stylesheet" href="{{ asset('css/fontawesome6.min.css') }}">
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" /> --}}

        <!-- Swiper JS -->
        {{-- <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script> --}}
        <script src="{{ asset('js/fontawesome6.min.js') }}"></script>
        @yield('styles')
    </head>

<body class="h-full font-space-grotesk">
    <header class="max-w-[1440px] mx-auto">
        @include('frontend.partials.header')
    </header>
    <main class="max-w-[1440px] mx-auto">
        <x-frontend.loader />
        @yield('content')
    </main>
    <footer class="max-w-[1440px] mx-auto">
        @include('frontend.partials.footer')
    </footer>
    @yield('scripts')
</body>

</html>
