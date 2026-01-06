@extends('layouts.app')
@section('content')
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img class="mx-auto h-22 w-auto" src="{{ asset($settings['site_logo']) ?? '/public/default_image.png' }}"
                alt="Your Company">
            <div class="mt-6 text-center text-2xl/9 font-bold tracking-tight ">{{ __('labels.login.title') }}</div>
        </div>
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="bg-white px-6 py-12 shadow-sm sm:rounded-lg sm:px-12">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    @if ($errors->any())
                        <div class="rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="ml-3">
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul role="list" class="list-disc space-y-1 pl-5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div>
                        <label for="email" class="block text-sm/6 font-medium ">{{ __('labels.login.fields.email') }}</label>
                        <div class="mt-2">
                            <input type="email" name="email" id="email" autocomplete="email"
                                value="{{ old('email') }}" required
                                class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm/6 font-medium ">{{ __('labels.login.fields.password') }}</label>
                        <div class="mt-2">
                            <input type="password" name="password" id="password" autocomplete="current-password" required
                                class="form-input block w-full rounded-md border-gray-300 focus:custom-bg focus:border-[var(--default-background)] focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md custom-bg px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs cursor-pointer hover:opacity-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:custom-bg">
                        {{ __('labels.login.signin') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
