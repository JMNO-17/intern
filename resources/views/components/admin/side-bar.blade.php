<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
<div x-data="{ contentOpen: true, jobOpen: true, companyOpen: true, locationOpen: true, userOpen: true, aboutusOpen: true }" x-show="mobileSideBar" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/80" aria-hidden="true"></div>
    <div class="flex fixed inset-0">
        <div class="flex relative flex-1 mr-16 w-full max-w-xs">
            <div class="flex absolute top-0 left-full justify-center pt-5 w-16">
                <button @click="mobileSideBar = false" type="button" class="p-2.5 -m-2.5 cursor-pointer">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="text-white size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex overflow-y-auto flex-col gap-y-5 px-6 pb-4 bg-white grow">
                <div class="flex items-center h-16 shrink-0">
                    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                        alt="CMS" class="w-auto h-8">
                </div>
                <nav class="flex flex-col flex-1">
                    <ul role="list" class="flex flex-col flex-1 gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <!-- Dashboard -->
                                <li>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'custom-bg text-white' : 'text-black' }}">
                                        <i
                                            class="w-6 h-6 fa-solid fa-chart-simple"></i><span>{{ __('labels.dashboard.title') }}</span>
                                    </a>
                                </li>

                                <!-- Main Content Management -->
                                <li class="pt-4">
                                    <button @click="contentOpen = !contentOpen" type="button"
                                        class="flex justify-between items-center w-full text-xs font-semibold tracking-wider leading-6 text-gray-400 uppercase focus:outline-none">
                                        <span>{{ __('labels.dashboard.content') }}</span><i
                                            class="transition-transform duration-200 fas fa-chevron-down"
                                            :class="{ 'rotate-180': contentOpen }"></i>
                                    </button>
                                </li>
                                <template x-if="contentOpen">
                                    <div>
                                        <li>
                                            <a href="{{ route('admin.sitemap.index') }}"
                                                aria-label="{{ __('labels.sitemap.title') }}"
                                                class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                        {{ request()->routeIs('admin.sitemap.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                <i
                                                    class="flex-shrink-0 w-6 h-6 fas fa-map"></i><span>{{ __('labels.sitemap.title') }}</span>
                                            </a>
                                        </li>
                                        @can('menu_access')
                                            <li>
                                                <a href="{{ route('admin.menus.index') }}"
                                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                    {{ request()->routeIs('admin.menus.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                    <i
                                                        class="flex-shrink-0 w-6 h-6 fas fa-bars"></i><span>{{ __('labels.menu.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('section_access')
                                            <li>
                                                <a href="{{ route('admin.sections.index') }}"
                                                    aria-label="{{ __('labels.section.title') }}"
                                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                    {{ request()->routeIs('admin.sections.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                    <i
                                                        class="flex-shrink-0 w-6 h-6 fas fa-layer-group"></i><span>{{ __('labels.section.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('bannerslider_access')
                                            <li>
                                                <a href="{{ route('admin.bannersliders.index') }}"
                                                    aria-label="{{ __('labels.bannerslider.title') }}"
                                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                    {{ request()->routeIs('admin.bannersliders.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                    <i
                                                        class="flex-shrink-0 w-6 h-6 fa-solid fa-images"></i><span>{{ __('labels.bannerslider.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('category_access')
                                            <li>
                                                <a href="{{ route('admin.categories.index') }}"
                                                    aria-label="{{ __('labels.category.title') }}"
                                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                    {{ request()->routeIs('admin.categories.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                    <i
                                                        class="flex-shrink-0 w-6 h-6 fas fa-tags"></i><span>{{ __('labels.category.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('product_access')
                                            <li>
                                                <a href="{{  route('admin.products.index') }}"
                                                aria-label="{{ __('labels.product.title') }}"
                                                class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                {{ request()->routeIs('admin.products.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                <i
                                                        class="flex-shrink-0 w-6 h-6 fas fa-box"></i><span>{{ __('labels.product.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('contentdescription_access')
                                            <li>
                                                <a href="{{ route('admin.contentdescriptions.index') }}"
                                                    aria-label="{{ __('labels.contentdescription.title') }}"
                                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                    {{ request()->routeIs('admin.contentdescriptions.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                    <i
                                                        class="flex-shrink-0 w-6 h-6 fas fa-file-alt"></i><span>{{ __('labels.contentdescription.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </div>
                                </template>

                                <!-- User Management -->
                                <li class="pt-4">
                                    <button @click="userOpen = !userOpen" type="button"
                                        aria-label="{{ __('labels.dashboard.user_management') }}"
                                        class="flex justify-between items-center w-full text-xs font-semibold tracking-wider leading-6 text-gray-400 uppercase focus:outline-none">
                                        <span>{{ __('labels.dashboard.user_management') }}</span>
                                        <i class="transition-transform duration-200 fas fa-chevron-down"
                                            :class="{ 'rotate-180': userOpen }"></i>
                                    </button>
                                </li>
                                <template x-if="userOpen">
                                    <div>
                                        @can('user_access')
                                            <li>
                                                <a href="{{ route('admin.users.index') }}"
                                                    aria-label="{{ __('labels.user.title') }}"
                                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                    {{ request()->routeIs('admin.users.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                    <i
                                                        class="flex-shrink-0 w-6 h-6 fas fa-users"></i><span>{{ __('labels.user.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('role_access')
                                            <li>
                                                <a href="{{ route('admin.roles.index') }}"
                                                    aria-label="{{ __('labels.role.title') }}"
                                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                    {{ request()->routeIs('admin.roles.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                    <i
                                                        class="flex-shrink-0 w-6 h-6 fas fa-user-shield"></i><span>{{ __('labels.role.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan

                                        @can('permission_access')
                                            <li>
                                                <a href="{{ route('admin.permissions.index') }}"
                                                    aria-label="{{ __('labels.permission.title') }}"
                                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                                    {{ request()->routeIs('admin.permissions.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                                    <i
                                                        class="flex-shrink-0 w-6 h-6 fas fa-key"></i><span>{{ __('labels.permission.title') }}</span>
                                                </a>
                                            </li>
                                        @endcan
                                    </div>
                                </template>
                            </ul>
                        </li>
                        <li class="mt-auto">
                            <a href="{{ route('admin.settings.index') }}"
                                aria-label="{{ __('labels.setting.title') }}"
                                class="group flex items-center gap-x-3 rounded-md  text-sm font-semibold
                                {{ request()->routeIs('admin.settings.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                <i
                                    class="flex-shrink-0 w-6 h-6 fas fa-cog"></i><span>{{ __('labels.setting.title') }}</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Static sidebar for desktop -->
<div x-data="{ contentOpen: true, jobOpen: true, companyOpen: true, locationOpen: true, userOpen: true, aboutusOpen: true }" class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <div class="flex overflow-y-auto flex-col gap-y-5 px-6 pb-4 bg-white border-r border-gray-200 opacity-90 grow">
        <div class="flex items-center h-16 shrink-0">
            <img class="w-auto h-10 bg-gray-100" src="{{ $settings['site_logo'] }}"
                alt="{{ $settings['site_name'] }}">
            <span class="px-3 text-lg font-semibold text-black">{{ $settings['site_name'] }}</span>
        </div>
        <nav class="flex flex-col flex-1">
            <ul role="list" class="flex flex-col flex-1 gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('admin.dashboard') }}" aria-label="{{ __('labels.dashboard.title') }}"
                                class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'custom-bg text-white' : 'text-black' }}">
                                <i
                                    class="w-6 h-6 fa-solid fa-chart-simple"></i><span>{{ __('labels.dashboard.title') }}</span>
                            </a>
                        </li>

                        <!-- Main Content Management -->
                        <li class="pt-4">
                            <button @click="contentOpen = !contentOpen" type="button"
                                class="flex justify-between items-center w-full text-xs font-semibold tracking-wider leading-6 text-gray-400 uppercase focus:outline-none">
                                <span>{{ __('labels.dashboard.content') }}</span><i
                                    class="transition-transform duration-200 fas fa-chevron-down"
                                    :class="{ 'rotate-180': contentOpen }"></i>
                            </button>
                        </li>
                        <template x-if="contentOpen">
                            <div>
                                <li>
                                    <a href="{{ route('admin.sitemap.index') }}"
                                        aria-label="{{ __('labels.sitemap.title') }}"
                                        class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                        {{ request()->routeIs('admin.sitemap.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                        <i
                                            class="flex-shrink-0 w-6 h-6 fas fa-map"></i><span>{{ __('labels.sitemap.title') }}</span>
                                    </a>
                                </li>
                                @can('menu_access')
                                    <li>
                                        <a href="{{ route('admin.menus.index') }}"
                                            aria-label="{{ __('labels.menu.title') }}"
                                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                            {{ request()->routeIs('admin.menus.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                            <i
                                                class="flex-shrink-0 w-6 h-6 fas fa-bars"></i><span>{{ __('labels.menu.title') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('section_access')
                                    <li>
                                        <a href="{{ route('admin.sections.index') }}"
                                            aria-label="{{ __('labels.section.title') }}"
                                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                            {{ request()->routeIs('admin.sections.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                            <i
                                                class="flex-shrink-0 w-6 h-6 fas fa-layer-group"></i><span>{{ __('labels.section.title') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('bannerslider_access')
                                    <li>
                                        <a href="{{ route('admin.bannersliders.index') }}"
                                            aria-label="{{ __('labels.bannerslider.title') }}"
                                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                            {{ request()->routeIs('admin.bannersliders.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                            <i
                                                class="flex-shrink-0 w-6 h-6 fa-solid fa-images"></i><span>{{ __('labels.bannerslider.title') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('contentdescription_access')
                                    <li>
                                        <a href="{{ route('admin.contentdescriptions.index') }}"
                                            aria-label="{{ __('labels.contentdescription.title') }}"
                                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                            {{ request()->routeIs('admin.contentdescriptions.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                            <i
                                                class="flex-shrink-0 w-6 h-6 fas fa-file-alt"></i><span>{{ __('labels.contentdescription.title') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('category_access')
                                    <li>
                                        <a href="{{ route('admin.categories.index') }}"
                                            aria-label="{{ __('labels.category.title') }}"
                                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                            {{ request()->routeIs('admin.categories.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                            <i
                                                class="flex-shrink-0 w-6 h-6 fas fa-tags"></i><span>{{ __('labels.category.title') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('product_access')
                                <li>
                                    <a href="{{  route('admin.products.index') }}"
                                    aria-label="{{ __('labels.product.title') }}"
                                    class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                    {{ request()->routeIs('admin.products.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                    <i
                                            class="flex-shrink-0 w-6 h-6 fas fa-box"></i><span>{{ __('labels.product.title') }}</span>
                                    </a>
                                </li>
                                @endcan

                            </div>
                        </template>

                        <!-- User Management -->
                        <li class="pt-4">
                            <button @click="userOpen = !userOpen" type="button"
                                class="flex justify-between items-center w-full text-xs font-semibold tracking-wider leading-6 text-gray-400 uppercase focus:outline-none">
                                <span>{{ __('labels.dashboard.user_management') }}</span>
                                <i class="transition-transform duration-200 fas fa-chevron-down"
                                    :class="{ 'rotate-180': userOpen }"></i>
                            </button>
                        </li>
                        <template x-if="userOpen">
                            <div>
                                @can('user_access')
                                    <li>
                                        <a href="{{ route('admin.users.index') }}"
                                            aria-label="{{ __('labels.user.title') }}"
                                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                            {{ request()->routeIs('admin.users.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                            <i class="flex-shrink-0 w-6 h-6 fas fa-users"></i>
                                            <span>{{ __('labels.user.title') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('role_access')
                                    <li>
                                        <a href="{{ route('admin.roles.index') }}"
                                            aria-label="{{ __('labels.role.title') }}"
                                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                            {{ request()->routeIs('admin.roles.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                            <i
                                                class="flex-shrink-0 w-6 h-6 fas fa-user-shield"></i><span>{{ __('labels.role.title') }}</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('permission_access')
                                    <li>
                                        <a href="{{ route('admin.permissions.index') }}"
                                            aria-label="{{ __('labels.permission.title') }}"
                                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                                            {{ request()->routeIs('admin.permissions.*') ? 'custom-bg text-white ' : 'text-black' }}">
                                            <i
                                                class="flex-shrink-0 w-6 h-6 fas fa-key"></i><span>{{ __('labels.permission.title') }}</span>
                                        </a>
                                    </li>
                                @endcan

                            </div>
                        </template>

                    </ul>
                </li>
                @can('setting_edit')
                    <li class="-mx-2 mt-auto">
                        <a href="{{ route('admin.settings.index') }}" aria-label="{{ __('labels.setting.title') }}"
                            class="group flex items-center gap-x-3 rounded-md p-2 text-sm font-semibold
                            {{ request()->routeIs('admin.settings.*') ? 'custom-bg text-white ' : 'text-black' }}">
                            <i class="flex-shrink-0 w-6 h-6 fas fa-cog"></i><span>{{ __('labels.setting.title') }}</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>
    </div>
</div>
