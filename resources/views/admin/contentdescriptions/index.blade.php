@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            <div class="px-4 py-6 sm:p-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">
                            {{ __('labels.contentdescription.title') }}
                        </div>
                        <p class="mt-2 text-sm text-gray-700">{{ __('labels.contentdescription.description') }}</p>
                    </div>
                    @can('contentdescription_create')
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <a href="{{ route('admin.contentdescriptions.create') }}"
                                class="block rounded-md custom-bg px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{__('global.add')}} {{__('labels.contentdescription.title_singular')}}
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="mt-8 overflow-x-auto">
                    @foreach (['success', 'error'] as $msgType)
                        @if ($message = Session::get($msgType))
                            @include('admin.common.success-error-message', [
                                'type' => $msgType,
                                'message' => $message,
                            ])
                        @endif
                    @endforeach
                    
                    <table id="contentdescription-table"
                        class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg text-sm text-left text-gray-700">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('global.no') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">
                                    {{ __('labels.about.fields.section_id') }} ({{ __('labels.section.fields.menu_id') }})
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold">
                                    {{ __('labels.contentdescription.fields.title') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold">
                                    {{ __('labels.contentdescription.fields.description') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">{{ __('global.action') }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($data as $record)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $loop->iteration ?? '' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $record->section->name ?? '' }}
                                        ({{ $record->section->menu->name ?? '' }})
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $record->title }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $record->description }}
                                    </td>
                                    <td class="px-6 py-4 flex items-center justify-end gap-2">
                                        @can('contentdescription_access')
                                            <a href="{{ route('admin.contentdescriptions.show', $record) }}"
                                                class="custom-color hover:text-indigo-900" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('contentdescription_edit')
                                            <a href="{{ route('admin.contentdescriptions.edit', $record) }}"
                                                class="custom-color hover:text-indigo-900" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan
                                        @can('contentdescription_delete')
                                            <x-admin.delete-popup :id="$record->id" :action="route('admin.contentdescriptions.destroy', $record->id)" :isDestroy="true">
                                                <button type="submit"
                                                    class="text-gray-600 hover:text-red-600 px-2 cursor-pointer" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </x-admin.delete-popup>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        if (document.getElementById("contentdescription-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#contentdescription-table", {
                searchable: true,
                sortable: true,
                perPage: 10,
                perPageSelect: [10, 20, 30, 50, 100],
            });
        }
    </script>
@endsection
