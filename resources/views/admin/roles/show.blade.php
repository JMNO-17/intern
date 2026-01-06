@extends('layouts.admin ')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            <div class="px-4 py-6 sm:p-8">

                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">
                            {{__('global.show')}}
                            {{__('labels.role.title')}}
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin.roles.index')}}" class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-gray-100 to-gray-800 text-white text-sm font-semibold shadow-lg transition">
                            {{__('global.back')}}
                        </a>
                    </div>
                </div>

                <div class="mt-8 flow-root">
                    @if ($message = Session::get('success'))
                        <div class="rounded-md bg-green-100 p-4 my-3">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">{{ $message }}</h3>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow-sm ring-1 ring-black/5 sm:rounded-lg">
                                <table id="role-table" class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                {{__('labels.role.fields.name')}}
                                            </th>
                                            <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                {{__('labels.permission.title_singular')}}
                                            </th>
                                            <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6">
                                                <span class="sr-only"></span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <td class="p-3">{{$role->name}}</td>
                                        <td class="p-3">
                                            @foreach($role->permissions as $key => $item)
                                                <span class="inline-block bg-[var(--default-background)] text-white text-xs font-semibold px-2.5 py-0.5 rounded my-1">{{ $item->display_name }}</span>
                                            @endforeach
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
