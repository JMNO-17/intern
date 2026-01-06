@extends('layouts.admin ')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            <div class="px-4 py-6 sm:p-8">

                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">
                            {{ __('labels.role.title') }}
                        </div>
                        <p class="mt-2 text-sm text-gray-700">{{ __('labels.role.description') }}</p>
                    </div>
                    @can('role_create')
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <a href="{{ route('admin.roles.create') }}"
                                class="block rounded-md custom-bg px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{ __('global.add') }}
                                {{ __('labels.role.title_singular') }}

                            </a>
                        </div>
                    @endcan
                </div>

                <div class="mt-8 overflow-x-auto">
                    @if ($message = Session::get('success'))
                        <div class="rounded-md bg-green-100 p-4 my-3">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">{{ $message }}</h3>
                                </div>
                            </div>
                        </div>
                    @endif
                    <table id="role-table"
                        class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg text-sm text-left text-gray-700">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('global.no') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">
                                    {{ __('labels.role.fields.name') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold">
                                    {{ __('labels.permission.title_singular') }}
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">{{ __('global.action') }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($roles as $role)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $loop->iteration ?? '' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $role->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @foreach ($role->permissions as $item)
                                            <span
                                                class="inline-block bg-[var(--default-background)] text-white text-xs font-semibold px-2.5 py-0.5 rounded my-1">{{ $item->display_name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 flex items-center justify-end gap-2">
                                        @can('role_access')
                                            <a href="{{ route('admin.roles.show', $role) }}"
                                                class="custom-color hover:text-indigo-900" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('role_edit')
                                            <a href="{{ route('admin.roles.edit', $role) }}"
                                                class="custom-color hover:text-indigo-900" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan
                                        @can('role_delete')
                                            <x-admin.delete-popup :id="$role->id" :action="route('admin.roles.destroy', $role->id)" :isDestroy="true">
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
        if (document.getElementById("role-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#role-table", {
                searchable: true,
                sortable: true,
                perPageSelect: [10, 50, 100, 500, 1000],
            });
        }
    </script>
@endsection
