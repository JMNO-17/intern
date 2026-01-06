@extends('layouts.admin')
@section('content')
    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <form action="{{ route('admin.menus.update', $menu) }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
            @method('PUT')
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="text-base/7 font-semibold text-gray-900">
                            {{ trans('global.edit') }} {{ __('labels.menu.title_singular') }}
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.menu.fields.name') }}
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', $menu->name) }}" autocomplete="given-name" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-1 focus:outline-[var(--default-background)] sm:text-sm/6">
                                </div>
                                @if ($errors->has('name'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'name',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-start gap-x-6">
                    <button type="submit"
                        class="rounded-md custom-bg px-3 py-2 text-sm font-semibold text-white shadow-xs cursor-pointer focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ __('global.update') }}
                    </button>
                    <a href="{{ route('admin.menus.index') }}"
                        class="text-sm/6 font-semibold custom-color cursor-pointer px-3 py-1 hover:outline rounded-md">
                        {{ __('global.cancel') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
