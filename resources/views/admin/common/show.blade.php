@extends('layouts.admin')
@section('content')
    @php
        $redirect_route = $redirect_route ?? '#';
        $model = __("labels.$label.title_singular");
        $title = "labels.$label.fields.";
    @endphp
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="px-4 py-6 sm:p-8">
                <div class="mb-5 sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="font-semibold">
                            {{ __('global.show') }}
                            {{ $model }}
                        </div>
                    </div>
                    <div>
                        <a href="{{ $redirect_route }}"
                            class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-gray-100 to-gray-800 text-white text-sm font-semibold shadow-lg transition hover:from-gray-500 hover:to-gray-100">
                            {{ __('global.back') }}
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-100">
                    <dl class="divide-y divide-gray-100">
                        @foreach ($fields as $key => $value)
                            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-900">{{ __($title . $key) }}</dt>
                                <dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    @if (
                                        $value instanceof \Illuminate\Support\Collection &&
                                            $value->first() instanceof \Spatie\MediaLibrary\MediaCollections\Models\Media)
                                        <div class="flex flex-wrap space-x-2">
                                            @foreach ($value as $media)
                                                <img src="{{ $media->getFullUrl() }}" alt="{{ $key }}"
                                                    class="h-32 mb-2">
                                            @endforeach
                                        </div>
                                    @elseif ($value instanceof \Spatie\MediaLibrary\MediaCollections\Models\Media)
                                        <img src="{{ $value->getFullUrl() }}" alt="{{ $key }}" class="h-32">
                                    @else
                                        @if ($key === 'status')
                                            {{ $value ? 'Active' : 'Inactive' }}
                                        @else
                                            {{ $value ?? '-' }}
                                        @endif
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
