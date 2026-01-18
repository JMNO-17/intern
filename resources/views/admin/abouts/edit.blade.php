@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <form action="{{ route('admin.abouts.update', $about) }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            @method('PUT')
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="text-base/7 font-semibold text-gray-900">
                            {{ trans('global.edit') }} {{ __('labels.about.title_singular') }}
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="section_id" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.about.fields.section_id') }} ({{ __('labels.section.fields.menu_id') }})
                                </label>
                                <div class="mt-2">
                                    <select id="section_id" name="section_id" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
                                        <option value="">{{ __('labels.about.fields.section_id') }}</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ old('section_id', $about->section_id) == $section->id ? 'selected' : '' }}>
                                                {{ $section->name }} ({{ $section->menu->name ?? '' }})
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
                                <label for="name" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.about.fields.name') }}
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', $about->name) }}" autocomplete="given-name" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
                                </div>
                                @if ($errors->has('name'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'name',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            {{-- <div class="sm:col-span-full">
                                <label for="description" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.about.fields.description') }}
                                </label>
                                <div class="mt-2">
                                    <textarea name="description" id="description" autocomplete="given-description" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">{{ old('description', $about->description) }}
                                    </textarea>
                                </div>
                                @if ($errors->has('description'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'description',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div> --}}
                            <div class="sm:col-span-full">
                                <label for="description" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.about.fields.description') }}
                                </label>
                                {{-- <div class="mt-2">
                                    <textarea name="description" id="description" autocomplete="given-description" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">{{ old('description', $about->description) }}
                                    </textarea>
                                </div> --}}
                                <div class="mt-2">
                                    <div id="description-area" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm">{!! old('description', $about->description) !!}</div>
                                    <textarea id="description" name="description" hidden>{{ old('description', $about->description) }}</textarea>
                                </div>
                                @if ($errors->has('description'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'description',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>

                            <div class="col-span-full">
                                <label for="about_image" class="block text-sm font-medium text-gray-900">
                                    {{ __('labels.about.fields.about_image') }}
                                </label>
                                <div class="mt-2 flex flex-col gap-y-2">
                                    <div id="aboutImageDropzone"
                                        class="needsclick dropzone rounded-md border-2 border-dashed border-gray-300 bg-gray-50 p-4">
                                    </div>
                                    <div class="flex items-center gap-x-3 mt-2">
                                        <span class="text-xs text-gray-500">{{ __('global.valid_formats') }}
                                            {{ __('global.max_size') }}</span>
                                    </div>
                                </div>
                                @error('about_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-start gap-x-6">
                    <button type="submit"
                        class="rounded-md custom-bg px-3 py-2 text-sm font-semibold text-white shadow-xs cursor-pointer hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ __('global.update') }}
                    </button>
                    <a href="{{ route('admin.abouts.index') }}"
                        class="text-sm rounded-md hover:outline font-semibold custom-color px-4 py-2 cursor-pointer">
                        {{ __('global.cancel') }}
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.aboutImageDropzone = {
            url: '{{ route('admin.abouts.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 5,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="about_image[]" value="' + response.name + '">')
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
                        $('form').find('input[name="about_image[]"][value="' + name + '"]').remove();
                        removeMedia(file.name, 'about_image');
                    }
                });
            },
            init: function() {
                @if (isset($about) && $about->getMedia('about_image')->count())
                    @php
                        $aboutImages = $about->getMedia('about_image');
                    @endphp
                    @if ($aboutImages->count() > 1)
                        @foreach ($aboutImages as $media)
                            var fileName = {!! json_encode($media->file_name) !!};
                            var mockFile = {
                                name: fileName,
                                size: 2,
                                accepted: true
                            };
                            var publicUrl = {!! json_encode($media->getFullUrl()) !!};
                            this.emit('addedfile', mockFile);
                            this.emit('thumbnail', mockFile, publicUrl);
                            this.emit('complete', mockFile);
                            this.files.push(mockFile);
                        @endforeach
                    @else
                        @php
                            $media = $aboutImages->first();
                        @endphp
                        var fileName = {!! json_encode($media->file_name) !!};
                        var mockFile = {
                            name: fileName,
                            size: 2,
                            accepted: true
                        };
                        var publicUrl = {!! json_encode($media->getFullUrl()) !!};
                        this.emit('addedfile', mockFile);
                        this.emit('thumbnail', mockFile, publicUrl);
                        this.emit('complete', mockFile);
                        this.files.push(mockFile);
                    @endif
                @endif
            }
        }

        function removeMedia(file_name, type) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.abouts.removeMedia') }}',
                data: {
                    'file_name': file_name,
                    'type': type,
                    'id': {!! $about->id !!}
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        text: "Successfully Removed Image!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(data) {
                    console.log(data.error);
                }
            });
        }

        // Quill Editor Initialization

          if (document.getElementById('description')) {
            var editor = new Quill('#description-area', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ align: ['right', 'center', 'justify'] }],
                        [{ color: ['#000000', '#ff0000', '#00ff00'] }],
                        ['image'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['clean']
                    ]
                }
            });

            var description = document.getElementById('description');

            // Initial sync from the editor content into the hidden textarea
            description.value = editor.root.innerHTML;

            editor.on('text-change', function() {
                description.value = editor.root.innerHTML;
            });

            // Ensure textarea is updated on form submit (safety)
            document.querySelector('form').addEventListener('submit', function() {
                description.value = editor.root.innerHTML;
            });
        }

    </script>
@endsection
