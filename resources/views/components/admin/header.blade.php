<div
    class="sticky top-0 z-40 flex justify-end h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-xs sm:gap-x-6 sm:px-6 lg:px-8">
    <!-- bg-[#011B54] -->
    <button @click="mobileSideBar = true" type="button" class="-m-2.5 p-2.5 cursor-pointer text-gray-700 lg:hidden">
        <span class="sr-only">Open sidebar</span>
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
            data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>
    <!-- Separator -->
    <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>
    <div class="flex gap-x-4 lg:gap-x-6">
        {{-- <div class="text-white">hi</div> --}}
        <div class="flex items-center justify-end gap-x-4 lg:gap-x-6">
            {{-- <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
                <span class="sr-only">View notifications</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </button> --}}

            <!-- Separator -->
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true"></div>
            <!-- Profile dropdown -->
            <div x-data="{ profileDropDown: false }" class="relative">
                <button @click="profileDropDown = ! profileDropDown" type="button"
                    class="-m-1.5 flex items-center p-1.5 cursor-pointer" id="user-menu-button" aria-expanded="false"
                    aria-haspopup="true">
                    <span class="sr-only">Open user menu</span>
                    <img src="{{ optional(auth()->user()?->getMedia('profile_image')->first())->getFullUrl() ?? asset('/user_avatar.png') }}"
                        class="size-8 rounded-full bg-gray-50 border" alt="Profile image">
                    <span class="hidden lg:flex lg:items-center">
                        <span class="ml-4 text-sm/6 font-semibold" aria-hidden="true">
                            {{ optional(auth()->user())->name }}
                        </span>
                        <svg class="ml-2 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>
                <div x-show="profileDropDown"
                    class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-hidden"
                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    @php
                        $profileRoute = null;
                        $profileRoute = route('admin.profile');
                    @endphp
                    @if ($profileRoute)
                        <a href="{{ $profileRoute }}"
                            class="block px-3 py-1 text-sm/6 text-gray-900 hover:text-gray-300" role="menuitem"
                            tabindex="-1" id="user-menu-item-0">Your profile</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" id="user-menu-item-1"
                            class="block px-3 py-1 cursor-pointer text-sm/6 text-gray-900 hover:text-gray-300"
                            role="menuitem" tabindex="-1">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
