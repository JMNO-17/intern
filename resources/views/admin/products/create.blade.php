@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
         <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    @if ($errors->has('products'))
                        <div class="rounded-md bg-red-50 p-4 mt-3">
                            <div class="flex">
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        {{ $errors->first('products') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="text-base/7 font-semibold text-gray-900">
                            {{ __('global.create') }}
                            {{ __('labels.product.title_singular') }}
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="category_id" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.product.fields.category_id') }} ({{ __('labels.category.fields.name') }})
                                </label>
                                <div class="mt-2">
                                    <select name="category_id" id="category_id" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
                                        <option value="">{{ __('labels.product.fields.category_id') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                                @if(optional($category->menu)->name)
                                                    ({{ $category->menu->name }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($errors->has('category_id'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'category_id',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>
                            <div class="sm:col-span-3">
                                    <label for="name" class="block text-sm/6 font-medium text-gray-900 required">
                                        {{ __('labels.product.fields.name') }}
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name" value="{{ old('name', '') }}" autocomplete="given-name" required
                                            class="form-input block w-full rounded-md customText border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
                                    </div>
                                    @if ($errors->has('name'))
                                        @include('admin.common.validation-error', [
                                            'field' => 'name',
                                            'errors' => $errors,
                                        ])
                                    @endif
                            </div>



                            <div class="sm:col-span-3">
                                <label for="price" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.product.fields.price') }}
                                </label>
                                <div class="mt-2">
                                    <input type="number" name="price" id="price" value="{{ old('price', '') }}" autocomplete="given-price" required
                                        class="form-input block w-full rounded-md customText border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm" step="0.01" min="0">
                                </div>
                                @if ($errors->has('price'))
                                    @include('admin.common.validation-error', [
                                        'field' => 'price',
                                        'errors' => $errors,
                                    ])
                                @endif
                            </div>

                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                            <div class="sm:col-span-full">
                                <label for="description" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.product.fields.description') }}
                                </label>
                                {{-- <div class="mt-2">
                                    <textarea name="description" id="description" autocomplete="given-description" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">{{ old('description', '') }}</textarea>
                                </div> --}}
                                 <div class="mt-2">
                                    <div id="description-area" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm">{{ old('description', '') }}</div>
                                    <textarea name="description" id="description" class="hidden">{{ old('description', '') }}</textarea>
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
                                        {{ __('labels.product.fields.featured_image') }}
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
                                        {{ __('labels.product.fields.other_images') }}
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
                        class="rounded-md custom-bg px-3 py-2 text-sm font-semibold text-white shadow-xs cursor-pointer hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        {{ __('global.create') }}
                    </button>
                    <a href="{{ route('admin.products.index') }}"
                        class="text-sm py-2 px-4 hover:outline rounded-md font-semibold custom-color cursor-pointer">
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
            url: '{{ route('admin.products.storeMedia') }}',
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
            url: '{{ route('admin.products.storeMedia') }}',
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


