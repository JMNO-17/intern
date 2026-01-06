@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="my-4 bg-white ring-1 shadow-xs ring-gray-900/5 sm:rounded-xl md:my-8">
            <div class="px-4 py-6 space-y-5 sm:p-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">
                            {{ __('labels.sitemap.title') }}
                        </div>
                        <p class="mt-2 text-sm text-gray-700">{{ __('labels.sitemap.description') }}</p>
                    </div>
                </div>
                <div>
                    <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-4 xl:gap-x-8">
                        @foreach ($menus as $menu)
                            <li class="overflow-hidden rounded-xl outline outline-gray-200">
                                <div class="flex gap-x-4 items-center p-6 bg-gray-50 border-b border-gray-900/5">
                                    <div class="font-medium text-gray-900 text-sm/6">{{ $menu->name }}</div>
                                </div>
                                <dl class="px-6 py-4 -my-3 divide-y divide-gray-100 text-sm/6">
                                    @foreach ($menu->sections as $section)
                                        <div class="flex gap-x-4 justify-between py-3">
                                            <dt class="text-gray-500">
                                                {{ $section->name }}
                                                <span>({{ implode(', ', $section->getAvailableModules()) }})</span>
                                            </dt>
                                        </div>
                                    @endforeach
                                </dl>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
