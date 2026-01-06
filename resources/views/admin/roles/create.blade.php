@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <form action="{{ route('admin.roles.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    @if ($errors->has('permissions'))
                        <div class="rounded-md bg-red-50 p-4 mt-3">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        {{ $errors->first('permissions') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="text-base/7 font-semibold text-gray-900">
                            {{ __('global.create') }}
                            {{ __('labels.role.title_singular') }}
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.role.fields.name') }}
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', '') }}" autocomplete="given-name" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" />
                                </div>
                                @if ($errors->has('name'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'name',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>
                            <div class="sm:col-span-12">
                                <fieldset>
                                    <div class="sm:flex sm:items-center">
                                        <div class="sm:flex-auto">
                                            {{-- <div class="text-base font-semibold text-gray-900">Permissions</div> --}}
                                            <div class="">
                                                <label for=""
                                                    class="text-base font-semibold text-gray-900 pr-4">{{ __('labels.permission.title') }}</label>
                                                <span class="text-red-600">*</span>
                                                </label>
                                                <input class="select_all custom-color border-gray-300 rounded-sm focus:ring-[var(--default-background)]" type="checkbox" id="select_all"
                                                    name="select_all">
                                                <label class="ml-2 select_all" for="select_all">Select All</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap -mx-2">
                                        @foreach ($permissions as $permission)
                                            @foreach ($permission as $row)
                                                <div class="w-full md:w-1/4 px-2 my-1">
                                                    <div class="my-2">
                                                        <input type="checkbox" id="permission{{ $row->id }}"
                                                            name="permissions[]" class="permission-checkbox custom-color border-gray-300 rounded-sm focus:ring-[var(--default-background)]"
                                                            value="{{ $row->name }}">
                                                        <label class="ml-2"
                                                            for="permission{{ $row->id }}">{{ $row->display_name }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if (!$loop->last)
                                                <div class="w-full px-2">
                                                    <hr class="my-4 border-gray-300">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-start gap-x-6">
                    <button type="submit"
                        class="rounded-md custom-bg px-3 py-2 text-sm font-semibold text-white shadow-xs cursor-pointer hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ __('global.create') }}
                    </button>
                    <a href="{{ route('admin.roles.index') }}"
                        class="text-sm py-2 px-4 hover:outline rounded-md font-semibold custom-color cursor-pointer">
                        {{ __('global.cancel') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllCheckbox = document.getElementById("select_all");
            const checkboxes = document.querySelectorAll("input[type='checkbox']:not(#select_all)");

            selectAllCheckbox.addEventListener("change", function() {
                checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    if (!this.checked) {
                        selectAllCheckbox.checked = false;
                    } else {
                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
        });
    </script>
@endsection
