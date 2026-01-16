<div class="bg-white dark:bg-base3 px-5 lg:px-20 mx-0 w-full">
    <nav aria-label="Global"
        class="fixed top-0 left-0 right-0 z-50 w-auto mx-auto flex items-center justify-between bg-base3 text-black hover:text-white py-6 shadow">

        @php
            $settings = $settings ?? [];
            $all_menus = $all_menus ?? collect();
        @endphp
        <div class="flex lg:flex-1 px-5">
            <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">{{ $settings['site_name'] ?? config('app.name') }}</span>
                <img src="{{ $settings['site_logo'] ?? asset('images/logo.png') }}" alt="Logo"
                    class="w-[176px] h-8 dark:hidden" />
                <img src="{{ $settings['site_logo'] ?? asset('images/logo.png') }}" alt="Logo"
                    class="w-auto h-8 not-dark:hidden" />
            </a>
        </div>
        <div class="flex lg:hidden">
            <button type="button" id="bargar-menu-button" command="show-modal" commandfor="mobile-menu"
                class=" inline-flex items-center justify-center rounded-md text-white dark:text-white">
                <span class="sr-only">Open main menu</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                    aria-hidden="true" class="size-6">
                    <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12 flex items-center justify-center px-5">
            {{-- @foreach ($all_menus as $menu)
                @php $route = $menu->route_name ?? null; @endphp
                @if ($route && Route::has($route))
                    <a href="{{ route($route) }}" class="text-sm/6 font-semibold text-gray-900 dark:text-black hover:text-white">{{ $menu->name }}</a>
                @else
                    <a href="#" class="text-sm/6 font-semibold text-gray-900 dark:text-black hover:text-white">{{ $menu->name }}</a>
                @endif
            @endforeach --}}

            @foreach ($all_menus as $menu)
                <a href="#{{ $menu->route_name }}"
                    class="text-sm/6 font-semibold text-black dark:text-black hover:text-white">
                    {{ $menu->name }}
                </a>
            @endforeach


        </div>
        {{-- login  --}}
        {{-- <div class="hidden lg:flex lg:flex-1 lg:justify-end">
            <a href="{{ route('login') }}" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Log in
                <span aria-hidden="true">&rarr;</span>
            </a>
        </div> --}}
    </nav>


    <el-dialog>
        <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden ">
            <div tabindex="0" class="fixed inset-0 focus:outline-non text-white dark:text-whitee">
                <el-dialog-panel
                    class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-base3 p-6 sm:max-w-sm sm:ring-1 sm:ring-text-base2 dark:bg-text-base2 dark:sm:ring-text-base2">
                    <div class="flex items-center justify-between">
                        <a href="#" class="m-1.5 p-1.5">
                            <span class="sr-only">Your Company</span>
                            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                                alt="" class="h-8 w-auto dark:hidden" />

                            <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                                alt="" class="h-8 w-auto not-dark:hidden" />
                        </a>
                        <button type="button" command="close" commandfor="mobile-menu"
                            class=" rounded-md text-white dark:text-white">
                            <span class="sr-only">Close menu</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                data-slot="icon" aria-hidden="true" class="size-6">
                                <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-base3-500/10 dark:divide-white/10">
                            <div class="space-y-2 py-6">
                                {{-- @foreach ($all_menus as $menu)
                                    @php $route = $menu->route_name ?? null; @endphp
                                    @if ($route && Route::has($route))
                                        <a href="#{{ $menu->route_name }}"
                                            class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">{{ $menu->name }}</a>
                                    @endif        
                                @endforeach --}}


                                @foreach ($all_menus as $menu)
                                    <a href="#{{ $menu->route_name }}"
                                        class="-mx-3 block rounded-lg px-3 py-2 text-base2 font-semibold text-base2 hover:bg-base3 dark:text-black dark:hover:text-white">
                                        {{ $menu->name }}
                                    </a>
                                @endforeach


                            </div>
                            {{-- <div class="py-6">
                                <a href="#"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50 dark:text-white dark:hover:bg-white/5">Log
                                    in</a>
                            </div> --}}
                        </div>
                    </div>
                </el-dialog-panel>
            </div>
        </dialog>
    </el-dialog>
</div>
