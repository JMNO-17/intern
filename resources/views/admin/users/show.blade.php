@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8 py-6">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="px-4 py-6 sm:px-6 flex items-center gap-x-6">
                <img src="{{ $user->getMedia('profile_image')->first() ? $user->getMedia('profile_image')->first()->getFullUrl() : '/default_image.png' }}"
                    class="size-20 rounded-full bg-gray-50 border mr-6" alt="Profile image">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                    <div class="text-sm text-gray-500 mt-1">
                        @foreach ($user->roles as $role)
                            <span
                                class="inline-block bg-indigo-100 text-indigo-800 rounded px-2 py-0.5 mr-1">{{ $role->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-100">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900">Full name</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                            {{ $user->name }}
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900">{{__('labels.user.fields.email')}}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                            {{ $user->email }}
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900">Roles</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                            @foreach ($user->roles as $role)
                                <span>
                                    {{ $role->name }}
                                    {{ $loop->last ? '' : ',' }}
                                </span>
                            @endforeach
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-900">{{__('labels.user.fields.status')}}</dt>
                        <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                            @if ($user->status == true)
                                <span class="inline-block bg-[var(--default-background)] text-white text-xs font-semibold px-2.5 py-0.5 rounded my-1">{{ __('global.active') }}</span>
                            @else
                                <span class="inline-block bg-gray-300 text-[var(--default-background)] text-xs font-semibold px-2.5 py-0.5 rounded my-1">{{ __('global.inactive') }}</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
            <div class="px-4 py-6 sm:p-8 flex items-center justify-end gap-x-6">
                <a href="{{ route('admin.users.index')}}" class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-gray-100 to-gray-800 text-white text-sm font-semibold shadow-lg transition">
                    {{__('global.back')}}
                </a>
            </div>
        </div>
    </div>
@endsection
