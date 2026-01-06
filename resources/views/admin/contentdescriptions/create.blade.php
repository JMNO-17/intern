@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <form action="{{ route('admin.contentdescriptions.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="text-base/7 font-semibold text-gray-900">
                            {{ trans('global.create') }} {{ __('labels.contentdescription.title_singular') }}
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="section_id" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.contentdescription.fields.section_id') }} ({{ __('labels.section.fields.menu_id') }})
                                </label>
                                <div class="mt-2">
                                    <select name="section_id" id="section_id" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-[var(--default-background)] focus:-outline-offset-1 focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm/6">
                                        <option value="">Select Section</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}">
                                                {{ $section->name }} ({{ $section->menu->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('section_id'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'section_id',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>

                            <div class="sm:col-span-3">
                                <label for="title" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.contentdescription.fields.title') }}
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="title" id="title"
                                        value="{{ old('title', '') }}" required
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-[var(--default-background)] focus:-outline-offset-1 focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm/6">
                                </div>
                                @if ($errors->has('title'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'title',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>
                            <div class="sm:col-span-6">
                                <label for="description" class="block text-sm/6 font-medium text-gray-900">
                                    {{ __('labels.contentdescription.fields.description') }}
                                </label>
                                <div class="mt-2">
                                    <textarea name="description" id="description" rows="4"
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-[var(--default-background)] focus:-outline-offset-1 focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm/6">{{ old('description', '') }}</textarea>
                                </div>
                                @if ($errors->has('description'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'description',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>
                            <div class="sm:col-span-full">
                                <div class="col-span-full">
                                    <label for="featured_image" class="block text-sm font-medium text-gray-900">
                                        {{ __('labels.contentdescription.fields.featured_image') }}
                                    </label>
                                    <div class="mt-2 flex flex-col gap-y-2">
                                        <div id="featuredImageDropzone"
                                            class="needsclick dropzone rounded-md border-2 border-dashed border-gray-300 bg-gray-50 p-4">
                                        </div>
                                        <span class="text-xs text-gray-500">{{__('global.max_size')}} {{__('global.valid_formats')}}</span>
                                    </div>
                                    @error('featured_image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="sm:col-span-full">
                                <div class="col-span-full">
                                    <label for="other_images" class="block text-sm font-medium text-gray-900">
                                        {{ __('labels.contentdescription.fields.other_images') }}
                                    </label>
                                    <div class="mt-2 flex flex-col gap-y-2">
                                        <div id="otherImagesDropzone"
                                            class="needsclick dropzone rounded-md border-2 border-dashed border-gray-300 bg-gray-50 p-4">
                                        </div>
                                        <span class="text-xs text-gray-500">{{__('global.valid_formats')}} {{__('global.max_size')}}</span>
                                    </div>
                                    @error('other_images')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-start gap-x-6">
                    <button type="submit"
                        class="rounded-md custom-bg px-3 py-2 text-sm font-semibold text-white shadow-xs cursor-pointer focus-visible:outline-1 focus-visible:outline-offset-1 focus-visible:outline-blue">
                        {{ __('global.create') }}
                    </button>
                    <a href="{{ route('admin.contentdescriptions.index') }}"
                        class="text-sm/6 font-semibold custom-color cursor-pointer px-3 py-1 hover:outline rounded-md">
                        {{ __('global.cancel') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        var uploadedDocumentMap = {}
        var uploadedOtherImagesMap = {}
        
        Dropzone.options.featuredImageDropzone = {
            url: '{{ route('admin.contentdescriptions.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="featured_image[]" value="' + response.name + '">')
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
                        $('form').find('input[name="featured_image[]"][value="' + name + '"]').remove();
                        // removeMedia(file.name, 'featured_image');
                    }
                });
            },
        }

        Dropzone.options.otherImagesDropzone = {
            url: '{{ route('admin.contentdescriptions.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 5, // Allow multiple images
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'type': 'other_images'
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="other_images[]" value="' + response.name + '">')
                uploadedOtherImagesMap[file.name] = response.name
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
                            name = uploadedOtherImagesMap[file.name]
                        }
                        $('form').find('input[name="other_images[]"][value="' + name + '"]').remove();
                        // removeMedia(file.name, 'other_images');
                    }
                });
            },
        }
    </script>
@endsection
