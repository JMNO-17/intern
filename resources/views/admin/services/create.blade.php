@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="bg-white showdow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    @if ($errors->has('services'))
                    <div class="rounded-md bg-red-50 p-4 mt-3">
                        <div class="flex">
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    {{ $errors->first('services')}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="text-base/7 font-semibold text-gray-900">
                            {{ __('global.create') }}
                            {{ __('labels.service.title_singular') }}
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="section_id" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.service.fields.section_id') }} ({{ __('labels.section.fields.menu_id') }})
                                </label>
                                <div class="mt-2">
                                    <select name="section_id" id="section_id" required class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
                                        <option value="">{{ __('labels.service.fields.section_id') }}</option>
                                    @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">
                                        {{ old('section_id') == $section->id ? 'selected' : '' }}
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
                                <label for="name" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.service.fields.name')}}
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', '')}}" autocomplete="given-name" required
                                        class="form-input block w-full rounded-md customText border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
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
                            <div class="sm:col-span-full">

                                <label for="description" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.service.fields.description') }}
                                </label>
                                 <div class="mt-2">
                                    <div id="description-area" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm">{{ old('description', '') }}</div>
                                    <textarea name="description" id="description" class="hidden">{{ old('description', '') }}</textarea>
                                </div>


                                @if ($errors->has('description'))
                                @include('admin.common.validation-error',[
                                    'field' => 'desccription',
                                    'errors' => $errors,
                                ])
                                @endif
                            </div>
                             <div class="col-span-full">
                                <label for="service_image" class="block text-sm font-medium text-gray-900">
                                    {{ __('labels.service.fields.service_image') }}
                                </label>
                                <div class="mt-2 flex flex-col gap-y-2">
                                    <div id="serviceImageDropzone"
                                        class="needsclick dropzone rounded-md border-2 border-dashed border-gray-300 bg-gray-50 p-4">
                                    </div>
                                    <span class="text-xs text-gray-500">{{ __('global.valid_formats') }}
                                        {{ __('global.max_size') }}</span>
                                </div>
                                @error('service_image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-start gap-x-6">
                    <button type="submit"
                    class="rounded-md custom-bg px-3 py-2 text-sm font-semibold text-white shadow-xs cursor-pointer hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    {{ __('global.create')}}
                </button>
                <a href="{{ route('admin.services.index')}}" class="text-sm py-2 px-4 hover:outline rounded-md font-semibold custom-color sursor-pointer">
                    {{ __('global.cancel') }}
                </a>
                </div>
            </div>
    </div>
@endsection
@section('scripts')
    <script>
        var uploadedDocumentMap = {}
        Dropzone.options.serviceImageDropzone = {
            url: '{{ route('admin.services.storeMedia') }}',
            maxFilesize: 2, // MB
            maxFiles: 5,
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(file, response) {
                $(file.previewElement).find('.dz-error-message').text('You cannot upload any more files');
                $('form').append('<input type="hidden" name="service_image[]" value="' + response.name + '">')
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
                        $('form').find('input[name="service_image[]"][value="' + name + '"]').remove();
                        removeMedia(file.name, 'service_image');
                    }
                });
            },
            init: function() {}
        }

         // Quill Editor Initialization

         if (document.getElementById('description')) {
            var editor = new Quill('#description-area', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ header: [1,2,3,false] }],
            ['bold','italic','underline','strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['link','image'],
            ['clean']
        ]
    },
    formats: ['header','bold','italic','underline','strike','list','link','image'],
    clipboard: {
        matchVisual: false  // important: prevents Quill from auto-wrapping lists in <p>
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

