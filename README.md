# admin-dashboard

This template should help get you started developing with TailwindCSS.

## Recommended IDE Setup

[VSCode](https://code.visualstudio.com/)

## Customize configuration

See [TailwindCSS Configuration Reference](https://tailwindcss.com/).

<details>
<summary>

## Project Setup
</summary>

### Copying .env.example

    copy .env.example and rename .env

### Composer and npm setting up

    composer install and npm install

### Run migration process

    php artisan migrate:fresh --seed

### Key Generation

    php artisan key:generate [option]

### Compile and Hot-Reload for Development

    npm run dev

#### (or)

### Compile and Minify for Production

    npm run build

</details>

<details>
<summary>

## Quill Text Editor
</summary>

### Add on HTML

    <div class="mt-2">
        <div name="description-area" id="description-area" value="{{ old('description', '') }}" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
        </div>
        <input type="text" id="description" name="description" value="{{ old('description', '') }}" hidden>
    </div>

### Add on JS

    if(document.getElementById('description')) {
        var editor = new Quill('#description-area', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic','underline', 'strike'],
                    [{'align':['right','center','justify']}],
                    [{'color':['#000000', '#ff0000', '#00ff00']}],
                    ['image'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['clean']
                ]
            }
        });

        var description = document.getElementById('description');

        editor.on('text-change', function () {
            description.value = editor.root.innerHTML;
        });
    }

</details>

<details>
<summary>

## CRUD for Module
</summary>

#### Make Model, Controller and Seeder

    php artisan make:model ModelName -m

    php artisan make:controller Directory\Controller --resource

    php artisan make:seeder Seeder

#### Notes:

    add repository and interface (create file manual under Repositories and Interfaces)

    add permission in permission table seeder

    add routes in web.php

    add in controller.php
        - __construct function
        - abort_if(Gate::denies('permission_name'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    add language in labels.php

    add side bar menu in side-bar.blade.php

    add view(index,create...)

</details>

<details>
<summary>

## Single & Multiple Images Upload with Spatie
</summary>

### Add your blade

    <div class="sm:col-span-full">
        <div class="col-span-full">
            <label for="other_images" class="block text-sm font-medium text-gray-900">
                {{ __('labels.contentdescription.fields.other_images') }}
            </label>
            <div class="flex flex-col gap-y-2 mt-2">
                <div id="otherImagesDropzone"
                    class="p-4 bg-gray-50 rounded-md border-2 border-gray-300 border-dashed needsclick dropzone">
                </div>
                <span class="text-xs text-gray-500">{{ __('global.max_size') }}
                    {{ __('global.valid_formats') }}</span>
            </div>
            @error('other_images')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

### Add your script

    <script>
        var uploadedOtherImagesMap = {}
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
                        removeMedia(file.name, 'other_images');
                    }
                });
            },
            // Need init in edit
            init: function() {
                @if (isset($contentdescription) && $contentdescription->getMedia('other_images')->count() > 0)
                    @foreach ($contentdescription->getMedia('other_images') as $image)
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
                url: '{{ route('admin.contentdescriptions.removeMedia') }}',
                data: {
                    'file_name': file_name,
                    'type': type,
                    'id': {!! $contentdescription->id !!}
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

### Add your model

    use Spatie\MediaLibrary\HasMedia;
    use Spatie\MediaLibrary\InteractsWithMedia;

    class ModelName extends Model implements HasMedia
    {
        use HasFactory, ImageTrait, InteractsWithMedia;
        public function registerMediaCollections(): void
        {
            $this->addMediaCollection('featured_image')
                ->singleFile()
                ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

            $this->addMediaCollection('other_images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png','image/jpg', 'image/webp']);
        }
    }

### Add your controller

    public function storeMedia(Request $request)
    {
        if ($request->header('type')) {
            $path = storage_path('uploads/temp/contentdescriptionOtherImages/' . Auth::id());
        } else {
            $path = storage_path('uploads/temp/contentdescription/' . Auth::id());
        }

        $file = $request->file('file');
        $response = common::storeMedia($path, $file);
        return $response;
    }

    public function removeMedia(Request $request)
    {
        $type = $request->type;
        $contentdescription = ContentDescription::find($request->id);
        $status = false;
        if (! $contentdescription) {
            return response()->json([
                'status' => false,
                'type' => $type,
                'message' => 'Content Description not found.',
            ], 404);
        }
        if ($type == 'featured_image') {
            $contentdescription->clearMediaCollection('featured_image');
            $status = true;
        } elseif ($type == 'other_images') {
            if ($request->has('type') == 'other_images') {
                $media = $contentdescription->getMedia('other_images')->where('name', $request->file_name)->first();
                if ($media) {
                    $media->delete();
                    $status = true;
                }
            }
            $status = true;
        }

        return response()->json([
            'status' => $status,
            'type' => $type,
        ]);
    }

    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        abort_if(Gate::denies('permission_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        try {
            DB::beginTransaction();

            $images = $request->input('other_images', []);
            unset($request['other_images']);

            $model = Model::create($request->all());

            if (!empty($images)) {
                foreach ($images as $file) {
                    $tempPath = storage_path('uploads/temp/folder/' . Auth::id() . '/' . $file);
                    if (file_exists($tempPath)) {
                        try {
                            $model->addMedia($tempPath)->toMediaCollection('other_images');
                        } catch (Exception $e) {
                            Log::error("Failed to add media file: {$tempPath}", [
                                'error' => $e->getMessage(),
                                'model_id' => $model->id
                            ]);
                        }
                    }
                }

                // Clean up temp folder
                $tempFolder = storage_path('uploads/temp/folder/' . Auth::id());
                if (File::exists($tempFolder)) {
                    File::deleteDirectory($tempFolder);
                }
            }

        }catch (Exception $e) {
            DB::rollBack();
            Log::error("Model update failed", [
                'model_id' => $model->id,
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->withErrors(new \Illuminate\Support\MessageBag(['catch_exception' => $e->getMessage()]));
        }

        return redirect()->route('redirect_route')->with('success',__('global.created_success'));     
    }

</details>

<details>
<summary>

## Google Map Section
</summary>

### Add your blade

    <div class="w-full lg:py-8">
        <div class="google_map">
            {!! $settings['google_map'] !!}
        </div>
    </div>

### Add your style

    <style>
        .google_map {
            width: 100%;
            height: 200px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        @media (min-width: 1024px) {
            .google_map {
                height: 600px;
            }
        }

        .google_map iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>

</details>

<details>
<summary>

## Static Variable
</summary>

### Static Menu (Menu.php)
### /* If you change the route name, you need to change the route name in database. */

    const HOME_ROUTE_NAME       = 'home';
    const HIRING_ROUTE_NAME     = 'hiring';
    const SERVICES_ROUTE_NAME   = 'services';
    const SHIPOWNER_ROUTE_NAME  = 'shipowners';
    const ABOUTUS_ROUTE_NAME    = 'aboutus';

### Static Section(Section.php)
#### /* If you change the section name, you need to change the section name in database. */

    const BANNER_SLIDER = 'Home Banner';
    const OUR_STORY = 'Our Story';
    const OUR_BUSINESS = 'Our Business';
    const WE_ARE_HIRING = 'We are Hiring';

### SectionSeeder.php (Sample Seeder)

    $sections = [
        [
            'name'          => Section::BANNER_SLIDER,
            'menu_id'       => Menu::where('route_name', Menu::HOME_ROUTE_NAME)->first()->id,
            'created_at'    => Carbon::now()->format('Y-m-d'),
            'updated_at'    => Carbon::now()->format('Y-m-d'),
        ]
    ];

### OtherSeeder.php

    $bannerSliders = [
        [
            'section_id'        => Section::where('name', Section::BANNER_SLIDER)->first()->id,
            'name'              => 'Seafarer Recruitment and Placement Services',
            'description'       => 'Powerful, self-serve product and growth analytics to help you convert.',
        ],
    ];

</details>

<details>
<summary>

## Customized Backend Login 
</summary>

### web.php

    Route::group(['prefix' => 'site-dashboard', 'as' => 'admin.', 'middleware' => ['auth']],function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

</details>

