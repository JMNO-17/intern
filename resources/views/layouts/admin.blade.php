<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel Dashboard') }}</title>
    <link rel="icon" type="image/png" href="{{ asset($settings['favicon']) }}">
    <!-- Stylesheets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome6.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/quill.snow.css') }}" />

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/dropzone.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome6.min.js') }}"></script>
    <script src="{{ asset('js/flowbite.min.js') }}"></script>
    <script src="{{ asset('js/simple-datatables.min.js') }}"></script>
    <script src="{{ asset('js/quill.js') }}"></script>
    @if (isset($settings['default_bg_color']))
        <style>
            :root {
                --default-background: {{ $settings['default_bg_color'] }};
            }
        </style>
    @endif
</head>

<body x-data="{ mobileSideBar: false }" class="h-full font-inter bg-gray-100 text-gray-800">
    <div class="flex flex-col h-screen justify-between lg:pl-72">
        <x-admin.header />
        <div id="loader"
            class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-1000 opacity-100">
            <divs
                class="loader border-t-2 rounded-full border-gray-500 bg-gray-300 animate-spin aspect-square w-8 flex justify-center items-center">
            </divs>
        </div>
        <main class="mb-auto">
            @yield('content')
        </main>
        <footer class="bg-white">
            <div class="max-w-6xl mx-auto p-4">
                <div class="flex flex-col md:flex-row items-center py-3">
                    <div class="mb-2 md:mb-0 text-center font-semibold md:text-left text-sm">
                        ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        <a href="https://z.com/mm/" class="hover:underline hover:text-red-700">Z.com.</a>
                        All Rights reserved.
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <x-admin.side-bar />
    @yield('scripts')
    <script>
        // loading overlay
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader');
            loader.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                loader.style.display = 'none';
            }, 300);
        });
    </script>
</body>

</html>
