<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Admin Dashboard') }}</title>

    <link rel="icon" type="image/png" href="{{ asset($settings['favicon'] ?? 'images/favicon.png') }}">

    <!-- SEO -->
    <meta name="title" content="{{ $settings['seo_title'] ?? config('app.name') }}">
    <meta name="description" content="{{ $settings['seo_content'] ?? '' }}">
    <meta name="keywords" content="{{ env('SEO_KEYWORDS', 'Admin Dashboard') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/fontawesome6.min.css') }}">
    <script src="{{ asset('js/fontawesome6.min.js') }}"></script>

    @yield('styles')
</head>

<body class="h-full font-space-grotesk">

    <!-- HEADER / NAVBAR -->
    <header class="w-full">
        <div class="bg-white px-5 lg:px-20 w-full">
            <nav class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between bg-base3 py-4 shadow px-5">

                {{-- Logo --}}
                <div class="flex lg:flex-1">
                    <a href="#">
                        <img src="{{ $settings['site_logo'] ?? asset('images/logo.png') }}" class="w-[45px] h-auto border-none" />
                    </a>
                </div>

                {{-- Mobile menu button --}}
                <div class="lg:hidden">
                    <button command="show-modal" commandfor="mobile-menu">
                        <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex gap-x-12">
                    @foreach ($all_menus as $menu)
                        <a href="#{{ $menu->route_name }}"
                            class="nav-link relative text-sm font-semibold text-black
                                   lg:hover:text-white
                                   after:absolute after:left-0 after:-bottom-1
                                   after:h-0.5 after:w-0 after:bg-white
                                   after:transition-all after:duration-300
                                   lg:hover:after:w-full">
                            {{ $menu->name }}
                        </a>
                    @endforeach
                </div>
            </nav>

            {{-- Mobile menu --}}
            <dialog id="mobile-menu" class="lg:hidden backdrop:bg-transparent">
                <div class="fixed inset-0 bg-base3 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <img src="{{ $settings['site_logo'] ?? asset('images/logo.png') }}" class="h-8">
                        <button command="close" commandfor="mobile-menu">✕</button>
                    </div>

                    <div class="flex flex-col">
                        @foreach ($all_menus as $menu)
                            <a href="#{{ $menu->route_name }}"
                               command="close"
                               commandfor="mobile-menu"
                               class="block py-3 font-semibold text-black hover:text-white">
                                {{ $menu->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </dialog>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="w-full xs:w-full"> {{-- Add top margin to prevent overlap --}}
        <x-frontend.loader />
        @yield('content')
    </main>

    <!-- ACTIVE MENU SCRIPT -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const sections = document.querySelectorAll("section[id]");
            const navLinks = document.querySelectorAll(".nav-link");

            // Scroll active menu
            window.addEventListener("scroll", () => {
                let current = "";

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 120;
                    if (window.pageYOffset >= sectionTop) {
                        current = section.getAttribute("id");
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove("text-white");
                    link.classList.remove("after:w-full");

                    if (link.getAttribute("href") === "#" + current) {
                        link.classList.add("text-white");
                        link.classList.add("after:w-full");
                    }
                });
            });

            // Mobile menu links close fallback
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    const dialog = document.getElementById('mobile-menu');
                    if (dialog.open) dialog.close();
                });
            });
        });
    </script>

    <!-- FOOTER -->
    <footer class="w-full">
        @include('frontend.partials.footer')
    </footer>

    @yield('scripts')
</body>

</html>
