@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            <div class="px-4 py-6 sm:p-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">{{__('labels.user.title')}}</div>
                        <p class="mt-2 text-sm text-gray-700">
                            {{__('labels.user.description')}}
                        </p>
                    </div>
                    @can('user_create')
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <a href="{{ route('admin.users.create') }}"
                                class="block rounded-md custom-bg px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{__('global.add')}} {{__('labels.user.title_singular')}}
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
                    <table id="default-table"
                        class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg text-sm text-left text-gray-700">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.user.fields.id') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.user.fields.name') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.user.fields.email') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.user.fields.role') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.user.fields.status') }}</th>
                                <th scope="col" class="px-6 py-3"><span class="sr-only">{{__('global.action')}}</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $loop->iteration ?? '' }}</td>
                                    <td class="px-6 py-4">{{ $user->name }}</td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @foreach ($user->roles as $role)
                                            <span>{{ $role->name }}{{ $loop->last ? '' : ',' }}</span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">
                                        @include('admin.common.change-status',[
                                            'id' => $user->id,
                                            'status' => $user->status == true ? 'checked' : '',
                                            'url' => route('admin.change.user.status')
                                        ])
                                    </td>

                                    <td class="px-6 py-4 flex items-center justify-end gap-2">
                                        @can('user_access')
                                            <a href="{{ route('admin.users.show', $user) }}"
                                                class="custom-color hover:text-indigo-900" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endcan
                                        @can('user_edit')
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="custom-color hover:text-indigo-900" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        @endcan
                                        @can('user_delete')
                                            <x-admin.delete-popup :id="$user->id" :action="route('admin.users.destroy', $user->id)" :isDestroy="true">
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
        if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#default-table", {
                searchable: true,
                sortable: true,
                perPageSelect: [10, 50, 100, 500, 1000],
            });
        }

        document.querySelectorAll(".deleteForm").forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to delete?",
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#FF0000",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Submit the current form directly
                    }
                });
            });
        });
    </script>
@endsection
