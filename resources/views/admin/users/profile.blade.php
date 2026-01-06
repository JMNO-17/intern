@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8 my-4">
        @foreach (['success', 'error'] as $msgType)
            @if ($message = Session::get($msgType))
                @include('admin.common.success-error-message', [
                    'type' => $msgType,
                    'message' => $message,
                ])
            @endif
        @endforeach

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl">
            @csrf
            @method('PUT')
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="col-span-full">
                                <label for="profile_image" class="block text-sm font-medium text-gray-900">
                                    {{__('labels.profile.fields.image')}}
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
                                    {{__('labels.profile.fields.name')}}
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" autocomplete="given-name" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" />
                                </div>
                                @error('name')
                                    <div class="rounded-md bg-red-50 p-4 mt-3">
                                        <div class="flex">
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-red-800">{{ $message }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{__('labels.profile.fields.email')}}
                                </label>
                                <div class="mt-2">
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" autocomplete="email" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" />
                                </div>
                                @error('email')
                                    <div class="rounded-md bg-red-50 p-4 mt-3">
                                        <div class="flex">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-red-800">{{ $message }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="sm:col-span-3">
                                <label for="password" class="block text-sm/6 font-medium text-gray-900">
                                    {{__('labels.profile.fields.new_password')}}
                                </label>
                                <div class="mt-2">
                                    <input type="password" name="password" id="password" autocomplete="new-password"
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" />
                                </div>
                                @error('password')
                                    <div class="rounded-md bg-red-50 p-4 mt-3">
                                        <div class="flex">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-red-800">{{ $message }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @enderror
                            </div>
                            <div class="sm:col-span-3">
                                <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">
                                    {{__('labels.profile.fields.confirm_password')}}
                                </label>
                                <div class="mt-2">
                                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <button type="submit"
                        class="rounded-md custom-bg px-4 py-2 text-sm font-semibold text-white shadow cursor-pointer">
                    {{__('global.update')}}
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
                @if (isset($user) && $user->hasMedia('profile_image'))
                    var fileName = {!! json_encode($user->getMedia('profile_image')->first()->file_name) !!};
                    var mockFile = {
                        name: fileName,
                        size: 2,
                        accepted: true
                    };

                    // Get the media URL
                    var publicUrl = {!! json_encode($user->getMedia('profile_image')->first()->getUrl()) !!};

                    this.emit('addedfile', mockFile);
                    this.emit('thumbnail', mockFile, publicUrl);
                    this.emit('complete', mockFile);
                    this.files.push(mockFile);

                    // Add hidden input for existing file
                    $('form').append('<input type="hidden" name="profile_image[]" value="' + fileName + '">');
                    uploadedDocumentMap[fileName] = fileName;
                @endif
            }
        }

        function removeMedia(file_name, type) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.users.removeMedia') }}',
                data: {
                    'file_name': file_name,
                    'type': type,
                    'user_id': {!! $user->id !!}
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        text: "Successfully Removed Fature Image!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(data) {
                    console.log(data.error);
                }
            });
        }
    </script>
@endsection
