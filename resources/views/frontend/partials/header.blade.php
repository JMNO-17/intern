<div class="bg-white px-5 lg:px-20 w-full">

    <nav
        class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between
               bg-base3 py-6 shadow">

        {{-- LOGO --}}
        <div class="flex lg:flex-1">
            <a href="#">
                <img src="{{ $settings['site_logo'] ?? asset('images/logo.png') }}"
                     class="w-[45px] h-auto" />
            </a>
        </div>

        {{-- MOBILE BUTTON --}}
        <div class="lg:hidden">
            <button command="show-modal" commandfor="mobile-menu">
                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" stroke-width="1.5"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        {{-- DESKTOP MENU --}}
        <div class="hidden lg:flex gap-x-12">
            @foreach ($all_menus as $menu)
                <a href="#{{ $menu->route_name }}"
                   class="nav-link relative text-sm font-semibold text-black
                          hover:text-white
                          after:absolute after:left-0 after:-bottom-1
                          after:h-0.5 after:w-0 after:bg-white
                          after:transition-all after:duration-300
                          hover:after:w-full">
                    {{ $menu->name }}
                </a>
            @endforeach
        </div>
    </nav>

    {{-- MOBILE MENU --}}
    <dialog id="mobile-menu" class="lg:hidden backdrop:bg-transparent">
        <div class="fixed inset-0 bg-base3 p-6">
            <div class="flex justify-between items-center mb-6">
                <img src="{{ $settings['site_logo'] ?? asset('images/logo.png') }}"
                     class="h-8">
                <button command="close" commandfor="mobile-menu">
                    ✕
                </button>
            </div>

            @foreach ($all_menus as $menu)
                <a href="#{{ $menu->route_name }}"
                   command="close"
                   commandfor="mobile-menu"
                   class="block py-3 font-semibold text-black hover:text-white">
                    {{ $menu->name }}
                </a>
            @endforeach
        </div>
    </dialog>

</div>
