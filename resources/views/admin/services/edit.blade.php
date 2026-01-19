@extends('layouts.admin')
@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data"
        class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
        @method('PUT')
        @csrf
        <div class="px-4 py-6 sm:p-8">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-3">
                    <div class="text-base/7 font-semibold text-gray-900">
                        {{ trans('global.edit') }} {{ __('labels.service.title_singular') }}
                    </div>

                    {{-- Section & Name --}}
                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="section_id" class="block text-sm font-medium text-gray-900 required">
                                {{ __('labels.service.fields.section_id') }}
                                ({{ __('labels.section.fields.menu_id') }})
                            </label>
                            <select id="section_id" name="section_id" required
                                class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] sm:text-sm mt-2">
                                <option value="">{{ __('labels.service.fields.section_id') }}</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"
                                        {{ old('section_id', $service->section_id) == $section->id ? 'selected' : '' }}>
                                        {{ $section->name }} ({{ $section->menu->name ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('section_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="name" class="block text-sm font-medium text-gray-900 required">
                                {{ __('labels.service.fields.name') }}
                            </label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $service->name) }}" required
                                class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] sm:text-sm mt-2">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mt-10 sm:col-span-full">
                        <label for="description" class="block text-sm font-medium text-gray-900 required">
                            {{ __('labels.service.fields.description') }}
                        </label>
                        <div id="description-area"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 border outline-none focus:outline-2 focus:outline-indigo-600 mt-2">
                            {!! old('description', $service->description) !!}
                        </div>
                        <textarea id="description" name="description" hidden>{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Featured Image --}}
                    <div class="col-span-full mt-6">
                        <label for="service_image" class="block text-sm font-medium text-gray-900">
                            {{ __('labels.service.fields.service_image') }}
                        </label>
                        <div class="mt-2">
                            <div id="serviceImageDropzone"
                                class="needsclick dropzone rounded-md border-2 border-dashed border-gray-300 bg-gray-50 p-4">
                            </div>
                            <span class="text-xs text-gray-500">{{ __('global.valid_formats') }} {{ __('global.max_size') }}</span>
                        </div>
                        @error('service_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="mt-6 flex items-center gap-x-6">
                <button type="submit"
                    class="rounded-md custom-bg px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500">
                    {{ __('global.update') }}
                </button>
                <a href="{{ route('admin.services.index') }}"
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
    // Dropzone for Featured Image
    var uploadedDocumentMap = {}
    Dropzone.options.serviceImageDropzone = {
        url: '{{ route('admin.services.storeMedia') }}',
        maxFilesize: 2,
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        success: function(file, response) {
            $('form').append('<input type="hidden" name="service_image[]" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
        },
        removedfile: function(file) {
            Swal.fire({
                title: "Are you sure you want to remove this image?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#FF0000',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    file.previewElement.remove()
                    var name = file.file_name ? file.file_name : uploadedDocumentMap[file.name]
                    $('form').find('input[name="service_image[]"][value="'+name+'"]').remove()
                    removeMedia(name, 'service_image')
                }
            });
        },
        init: function() {
            @if(isset($service) && $service->getMedia('service_image')->count())
                var file = {!! json_encode($service->getMedia('service_image')->first()) !!};
                var mockFile = { name: file.file_name, size: 2, accepted: true };
                this.emit('addedfile', mockFile);
                this.emit('thumbnail', mockFile, file.full_url);
                this.emit('complete', mockFile);
                this.files.push(mockFile);
                uploadedDocumentMap[mockFile.name] = file.file_name;
                $('form').append('<input type="hidden" name="service_image[]" value="'+file.file_name+'">');
            @endif
        }
    }

    function removeMedia(file_name, type){
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.services.removeMedia') }}',
            data: {file_name: file_name, type: type, id: {{ $service->id }} },
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            success: function(){ Swal.fire({icon:'success', text:'Removed!', timer:1500, showConfirmButton:false}); },
            error: function(data){ console.log(data); }
        });
    }

    // Quill Editor
    if(document.getElementById('description')){
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
description.value = editor.root.innerHTML;
editor.on('text-change', function() {
    description.value = editor.root.innerHTML;
});
document.querySelector('form').addEventListener('submit', function() {
    description.value = editor.root.innerHTML;
});

    }
</script>
@endsection
