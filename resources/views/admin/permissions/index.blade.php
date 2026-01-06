@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            <div class="px-4 py-6 sm:p-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">{{__('labels.permission.title')}}</div>
                        <p class="mt-2 text-sm text-gray-700">{{__('labels.permission.description')}}</p>
                    </div>
                </div>
                
                <div class="flex flex-wrap -mx-2">
                    @foreach ($permissions as $permission)               
                        @foreach ($permission as $row)
                            <div class="w-full md:w-1/4 px-2 my-1">
                                <div class="my-2">
                                    <label class="ml-2" for="permission{{ $row->id }}">{{ $row->display_name }}</label>
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
            </div>
        </div>
    </div>
@endsection