@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="text-base/7 font-semibold text-gray-900">{{__('global.create')}} {{__('labels.user.title_singular')}}</div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="profile_image" class="block text-sm font-medium text-gray-900">
                                    {{__('labels.user.fields.profile_image')}}
                                </label>
                                <div class="mt-2 flex flex-col gap-y-2">
                                    <div id="profileImageDropzone"
                                        class="needsclick dropzone rounded-md border-2 border-dashed border-gray-300 bg-gray-50 p-4">
                                    </div>
                                    <span class="text-xs text-gray-500">{{__('global.valid_formats')}} {{__('global.max_size')}}</span>
                                </div>
                                @error('profile_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{__('labels.user.fields.name')}}
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', '') }}"
                                        autocomplete="given-name" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" />
                                </div>
                                @if ($errors->has('name'))
                                    @include('admin.common.validation-error', ['field' => 'name', 'errors' => $errors])
                                @endif
                            </div>
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{__('labels.user.fields.email')}}
                                </label>
                                <div class="mt-2">
                                    <input id="email" name="email" type="email" value="{{ old('email', '') }}"
                                        autocomplete="email" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" />
                                </div>
                                @if ($errors->has('email'))
                                    @include('admin.common.validation-error', ['field' => 'email', 'errors' => $errors])
                                @endif
                            </div>
                            <div class="sm:col-span-3">
                                <label for="password" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{__('labels.user.fields.password')}}
                                </label>
                                <div class="mt-2">
                                    <input id="password" name="password" type="password" autocomplete="password" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" />
                                </div>
                                @if ($errors->has('password'))
                                    @include('admin.common.validation-error', ['field' => 'password', 'errors' => $errors])
                                @endif
                            </div>
                            <div class="sm:col-span-full">
                                <fieldset>
                                    <legend class="sr-only">By Roles</legend>
                                    <div class="sm:py-3">
                                        <div class="text-sm/6 font-semibold text-gray-900" aria-hidden="true">By Roles
                                        </div>
                                        <div class="mt-4 sm:col-span-2 sm:mt-2">
                                            <div class="w-full flex gap-2">
                                                @foreach ($roles as $role)
                                                    <div class="flex items-center w-full">
                                                        <input id="role_{{ $role->id }}" name="roles[]" type="checkbox"
                                                            value="{{ $role->name }}"
                                                            class="form-checkbox h-4 w-4 custom-color border-gray-300 rounded focus:ring-[var(--default-background)]" />
                                                        <label for="role_{{ $role->id }}"
                                                            class="ml-2 block text-sm text-gray-900 font-medium w-full break-words">
                                                            {{ ucfirst($role->name) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @if ($errors->has('roles'))
                                        @include('admin.common.validation-error', ['field' => 'roles', 'errors' => $errors])
                                    @endif
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('admin.users.index') }}"
                        class="text-sm font-semibold px-3 py-2 rounded-md hover:outline custom-color cursor-pointer">
                        {{__('global.cancel')}}
                    </a>
                    <button type="submit"
                        class="rounded-md custom-bg px-3 py-2 text-sm font-semibold text-white shadow-xs cursor-pointer hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{__('global.create')}}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.profileImageDropzone = {
            url: '{{ route('admin.users.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="profile_image[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            },
            removedfile: function(file) {
                Swal.fire({
                    title: "Are you sure you want to remove this image?",
                    text: "If you remove this, it will be delete from data.",
                    icon: "warning",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#FF0000',
                    confirmButtonText: 'Yes, delete it!'
                }).then((willDelete) => {
                    if (willDelete.isConfirmed) {
                        file.previewElement.remove()
                        var name = ''
                        if (typeof file.file_name !== 'undefined') {
                            name = file.file_name
                        } else {
                            name = uploadedDocumentMap[file.name]
                        }
                        $('form').find('input[name="profile_image[]"][value="' + name + '"]').remove();
                        removeMedia(file.name, 'profile_image');
                    }
                });
            },
            init: function() {
                @if (isset($user) && $user->profile_image)
                    var files =
                        {!! json_encode($user->profile_image) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="profile_image[]" value="' + file.file_name +
                            '">')
                    }
                @endif
            }
        }
    </script>
@endsection
