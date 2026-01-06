@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            <div class="px-4 py-6 sm:p-8">
                @foreach (['success', 'error'] as $msgType)
                    @if ($message = Session::get($msgType))
                        @include('admin.common.success-error-message', [
                            'type' => $msgType,
                            'message' => $message,
                        ])
                    @endif
                @endforeach
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">
                            {{ __('labels.menu.title') }}
                        </div>
                        <p class="mt-2 text-sm text-gray-700">{{ __('labels.menu.description') }}</p>
                    </div>
                </div>
                <div class="mt-8 overflow-x-auto">
                    <table id="menu-table"
                        class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg text-sm text-left text-gray-700">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('global.no') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">
                                    {{ __('labels.menu.fields.name') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">{{ __('global.action') }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($menus as $menu)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $loop->iteration ?? '' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $menu->name }}
                                    </td>
                                    <td class="px-6 py-4 flex items-center justify-end gap-2">
                                        @can('menu_access')
                                            <a href="{{ route('admin.menus.show', $menu) }}"
                                                class="custom-color hover:text-indigo-900" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('menu_edit')
                                            <a href="{{ route('admin.menus.edit', $menu) }}"
                                                class="custom-color hover:text-indigo-900" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
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
        if (document.getElementById("menu-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#menu-table", {
                searchable: true,
                sortable: true,
                perPage: 10,
                perPageSelect: [10, 20, 30, 50, 100],
            });
        }
    </script>
@endsection
