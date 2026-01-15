@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            @method('PUT')
            @csrf
            <div class="px-4 py-6 sm:p-8">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-3">
                        <div class="text-base/7 font-semibold text-gray-900">
                            {{ trans('global.edit') }} {{ __('labels.product.title_singular') }}
                        </div>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="section_id" class="block text-sm/6 font-medium text-gray-900 required">
                                    {{ __('labels.product.fields.section_id') }} ({{ __('labels.section.fields.name') }})
                                </label>
                                <div class="mt-2">
                                    <select id="section_id" name="section_id" required
                                        class="form-input block w-full rounded-md border-gray-300 focus:border-[var(--default-background)] focus:ring focus:ring-[var(--default-background)] focus:ring-opacity-50 sm:text-sm">
                                        <option value="">{{ __('labels.product.fields.section_id') }}</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                {{ old('section_id', $product->section_id) == $section->id ? 'selected' : '' }}>
                                                {{ $section->name }}
                                                @if(optional($section->menu)->name)
                                                    ({{ $section->menu->name }})
                                                @endif
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
                                    {{ __('labels.product.fields.name') }}
                                </label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" autocomplete="given-name" required
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
                        {{ __('global.update') }}
                    </button>
                    <a href="{{ route('admin.products.index') }}"
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
                        removeMedia(file.name, 'featured_image');
                    }
                });
            },
            init: function() {
                @if (isset($product) &&
                        $product->getMedia('featured_image')->first() &&
                        $product->getMedia('featured_image')->first() !== '/user-avatar.png')
                    var fileName = {!! json_encode(\App\Models\Product::getImageName($product->featured_image)) !!};

                    console.log('file name',fileName);
                    var mockFile = {
                        name: fileName,
                        size: 2,
                        accepted: true
                    };
                    // Always use a public URL for preview
                    var publicUrl = '';
                    var imgPath = {!! json_encode($product->getMedia('featured_image')->first()->getFullUrl()) !!};

                    console.log('path', imgPath);
                    if (imgPath.startsWith('/images/')) {
                        publicUrl = imgPath;
                    } else {
                        publicUrl = imgPath;
                    }
                    this.emit('addedfile', mockFile);
                    this.emit('thumbnail', mockFile, publicUrl);
                    this.emit('complete', mockFile);
                    this.files.push(mockFile);
                @endif
            }
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
                        removeMedia(file.name, 'other_images');
                    }
                });
            },
            init: function() {
                @if (isset($product) && $product->getMedia('other_images')->count() > 0)
                    @foreach ($product->getMedia('other_images') as $image)
                        var fileName = {!! json_encode($image->name) !!};
                        var mockFile = {
                            name: fileName,
                            size: 2,
                            accepted: true
                        };
                        var publicUrl = {!! json_encode($image->getFullUrl()) !!};
                        this.emit('addedfile', mockFile);
                        this.emit('thumbnail', mockFile, publicUrl);
                        this.emit('complete', mockFile);
                        this.files.push(mockFile);
                    @endforeach
                @endif
            }
        }

        function removeMedia(file_name, type) {
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.products.removeMedia') }}',
                data: {
                    'file_name': file_name,
                    'type': type,
                    'id': {!! $product->id !!}
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

       

    </script>
@endsection

