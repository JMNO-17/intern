@extends('layouts.admin')
@section('content')
    <style>
        .theme-bg {
            background-color: {{ $settings['default_bg_color'] ?? '#000' }};
        }
    </style>
    <div class="px-4 sm:px-6 lg:px-8">
        @foreach (['success', 'error'] as $msgType)
            @if ($message = Session::get($msgType))
                @include('admin.common.success-error-message', ['type' => $msgType, 'message' => $message])
            @endif
        @endforeach

        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 p-4 md:my-8">
            <div class="px-4 py-6 sm:p-4">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">
                            {{ __('labels.setting.title') }}
                        </div>
                        <div class="mt-2 text-sm text-gray-700">
                            {{ __('labels.setting.description') }}
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <div class=" border-gray-300 rounded-b p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Favicon -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 required" for="favicon">{{ __('labels.setting.fields.favicon') }}</label>
                                <div class="flex flex-row items-center justify-center gap-4">
                                    <img src="{{ $settings['favicon'] }}" id="preview_favicon" class="w-20 h-20 object-cover border rounded" alt="Favicon">
                                    <input type="hidden" id="old_favicon" value="{{ $settings['favicon'] }}">
                                    <a href="javascript:void(0)" style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:red;background:none;"
                                        class="p-0 glow deleteImage" id="delete_btn_favico" data-key="favicon" title="Delete Existing Image" aria-label="Delete Existing Image">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </div>
                                <input type="file" name="favicon" id="favicon" onchange="previewImage('favicon')" class="mt-2 block w-full text-sm text-gray-700 border border-gray-300 rounded shadow-sm file:mr-4 file:py-2 file:px-6 file:rounded file:border-0 file:bg-gray-100 file:text-gray-700">
                            </div>
                            <!-- Site Logo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 required" for="site_logo">
                                    {{ __('labels.setting.fields.site_logo') }}
                                </label>
                                <div class="flex flex-row items-center justify-center gap-4">
                                    <img src="{{ $settings['site_logo'] }}" id="preview_site_logo" class="w-20 h-20 object-cover border rounded" alt="Site Logo">
                                    <input type="hidden" id="old_site_logo" value="{{ $settings['site_logo'] }}">
                                    <span>
                                        <a href="javascript:void(0)" aria-label="Delete Existing Image"
                                            style="width: 26px;height: 36px;display: inline-block;line-height: 36px;border:none;color:red;background:none;"
                                            class="p-0 glow deleteImage" id="delete_btn_site_logo" data-key="site_logo" title="Delete Existing Image" aria-label="Delete Existing Image">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </span>
                                </div>
                                <input type="file" name="site_logo" id="site_logo" onchange="previewImage('site_logo')"
                                    class="mt-2 block w-full text-sm text-gray-700 border border-gray-300 rounded shadow-sm file:mr-4 file:py-2 file:px-6 file:rounded file:border-0 file:bg-gray-100 file:text-gray-700">
                            </div>

                        </div>


                        <div>
                            <!-- Site Description -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="site_description">{{ __('labels.setting.fields.site_description') }}</label>
                                <textarea type="text" name="site_description" id="site_description" rows="5"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('site_description') ? 'border-red-500' : '' }}">{{ $settings['site_description'] }}</textarea>
                            </div>
                        </div>

                        <div>
                            <!-- Site Name -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1 required" for="site_name">
                                    {{ __('labels.setting.fields.site_name') }}
                                </label>
                                <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('site_name') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <div>
                            <!-- Phone -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1 required"
                                    for="phone">{{ __('labels.setting.fields.phone') }}</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $settings['phone']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('phone') ? 'border-red-500' : '' }}">
                            </div>
                        </div>
                        <div>
                            <!-- Email -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1 required"
                                    for="email">{{ __('labels.setting.fields.email') }}</label>
                                <input type="text" name="email" id="email" value="{{ old('email', $settings['email']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('email') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <!-- Default Background Color -->
                        <div>
                            <label for="default_bg_color" class="block text-sm font-medium text-gray-700 mb-1 required">
                                {{ __('labels.setting.fields.default_bg_color') }}
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="default_bg_color" name="default_bg_color" aria-label="Default Background Color" value="{{ old('default_bg_color', $settings['default_bg_color']) }}"
                                    class="w-16 h-10 border border-gray-300 rounded focus:ring-[var(--default-background)] focus:border-[var(--default-background)] {{ $errors->has('default_bg_color') ? 'border-red-500' : '' }}">
                                <button type="button" id="reset-color" class="theme-bg text-sm px-3 py-2 cursor-pointer text-white bg-black hover:bg-yellow-700 hover:opacity-50 rounded">
                                    {{ __('global.reset') }}
                                </button>
                            </div>
                        </div>
                        <div>
                            <!-- Address -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="address">{{ __('labels.setting.fields.address') }}</label>
                                <textarea type="text" name="address" id="address"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('address') ? 'border-red-500' : '' }}">{{ $settings['address'] }}</textarea>
                            </div>
                        </div>

                    </div>
                    <div>
                        <!-- Google Map -->
                        <div class="w-full px-2 my-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1 required" for="google_map">{{ __('labels.setting.fields.google_map') }}</label>
                            <textarea type="text" name="google_map" id="google_map" rows="4"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('google_map') ? 'border-red-500' : '' }}">{{ $settings['google_map'] }}</textarea>
                        </div>
                    </div>
                </div>

                <div class=" border-gray-300 rounded-b p-4">
                    <div class="flex items-center gap-4 my-4 relative"  x-data="{ show: false }">
                        <hr class="flex-grow border-t border-gray-300">
                        <div class="relative" @mouseenter="show = true" @mouseleave="show = false">
                            <span class="whitespace-nowrap cursor-pointer text-sm font-semibold text-gray-700">{{ __('labels.setting.seo_settings') }}</span>
                            <!-- Tooltip -->
                            <div x-show="show" x-transition style="display: none;"
                                class="absolute z-10 w-72 p-3 text-sm text-white theme-bg rounded-md shadow-md left-1/2 -translate-x-1/2 top-full mt-3">
                                <span class="font-semibold text-yellow-400">{{ __('labels.setting.seo') }}</span> {{ __('labels.setting.seo_description') }}
                            </div>
                        </div>

                        <hr class="flex-grow border-t border-gray-300">
                    </div>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <!-- Seo Title -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1 required" for="seo_title">{{ __('labels.setting.fields.seo_title') }}</label>
                                <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title', $settings['seo_title']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('seo_title') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <div>
                            <!-- Seo Content -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1 required" for="seo_content">{{ __('labels.setting.fields.seo_content') }}</label>
                                <textarea type="text" name="seo_content" id="seo_content"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('seo_content') ? 'border-red-500' : '' }}">{{ $settings['seo_content'] }}</textarea>
                            </div>
                        </div>

                         <!-- Seo Keywords -->
                         <div class="w-full px-2 my-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1 required" for="seo_keywords">{{ __('labels.setting.fields.seo_keywords') }}</label>
                            <textarea type="text" name="seo_keywords" id="seo_keywords"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('seo_keywords') ? 'border-red-500' : '' }}">{{ $settings['seo_keywords'] }}</textarea>
                        </div>

                    </div>
                </div>

                <div class=" border-gray-300 rounded-b p-4">
                    <div class="flex items-center gap-4 my-4">
                        <hr class="flex-grow border-t border-gray-300">
                        <span class="whitespace-nowrap text-sm font-semibold text-gray-700">{{ __('labels.setting.social_links') }}</span>
                        <hr class="flex-grow border-t border-gray-300">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <!-- Facebook -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="facebook">
                                    {{ __('labels.setting.fields.facebook') }}
                                </label>
                                <input type="text" name="facebook" id="facebook" value="{{ old('facebook', $settings['facebook'] ?? '') }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('facebook') ? 'border-red-500' : '' }}">
                            </div>
                        </div>
                        <div>
                            <!-- LinkedIn -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="linkedin">
                                    {{ __('labels.setting.fields.linkedin') }}
                                </label>
                                <input type="text" name="linkedin" id="linkedin" value="{{ old('linkedin', $settings['linkedin']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('linkedin') ? 'border-red-500' : '' }}">
                            </div>
                        </div>
                        <div>
                            <!-- Twitter -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="twitter">
                                    {{ __('labels.setting.fields.twitter') }}
                                </label>
                                <input type="text" name="twitter" id="twitter" value="{{ old('twitter', $settings['twitter']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('twitter') ? 'border-red-500' : '' }}">
                            </div>
                        </div>
                        <div>
                            <!-- Instragram -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="instragram">
                                    {{ __('labels.setting.fields.instragram') }}
                                </label>
                                <input type="text" name="instragram" id="instragram" value="{{ old('instragram', $settings['instragram']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('instragram') ? 'border-red-500' : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" border-gray-300 rounded-b p-4">
                    <div class="flex items-center gap-4 my-4">
                        <hr class="flex-grow border-t border-gray-300">
                        <span class="whitespace-nowrap text-sm font-semibold text-gray-700">{{ __('labels.setting.quick_links') }}</span>
                        <hr class="flex-grow border-t border-gray-300">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <!-- Quick Link A -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="quick_link_a">
                                    {{ __('labels.setting.fields.quick_link_a') }}
                                </label>
                                <input type="text" name="quick_link_a" id="quick_link_a" value="{{ old('quick_link_a', $settings['quick_link_a']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('quick_link_a') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <div>
                            <!-- Quick Link B -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="quick_link_b">
                                    {{ __('labels.setting.fields.quick_link_b') }}
                                </label>
                                <input type="text" name="quick_link_b" id="quick_link_b" value="{{ old('quick_link_b', $settings['quick_link_b']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('quick_link_b') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <div>
                            <!-- Quick Link C -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="quick_link_c">
                                    {{ __('labels.setting.fields.quick_link_c') }}
                                </label>
                                <input type="text" name="quick_link_c" id="quick_link_c" value="{{ old('quick_link_c', $settings['quick_link_c']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('quick_link_c') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <div>
                            <!-- Quick Link D -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="quick_link_d">
                                    {{ __('labels.setting.fields.quick_link_d') }}
                                </label>
                                <input type="text" name="quick_link_d" id="quick_link_d" value="{{ old('quick_link_d', $settings['quick_link_d']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('quick_link_d') ? 'border-red-500' : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" border-gray-300 rounded-b p-4">
                    <div class="flex items-center gap-4 my-4">
                        <hr class="flex-grow border-t border-gray-300">
                        <span class="whitespace-nowrap text-sm font-semibold text-gray-700">{{ __('labels.setting.useful_links') }}</span>
                        <hr class="flex-grow border-t border-gray-300">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <!-- Useful Link A -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="useful_link_a">
                                    {{ __('labels.setting.fields.useful_link_a') }}
                                </label>
                                <input type="text" name="useful_link_a" id="useful_link_a" value="{{ old('useful_link_a', $settings['useful_link_a']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('useful_link_a') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <div>
                            <!-- Useful Link B -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="useful_link_b">
                                    {{ __('labels.setting.fields.useful_link_b') }}
                                </label>
                                <input type="text" name="useful_link_b" id="useful_link_b" value="{{ old('useful_link_b', $settings['useful_link_b']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('useful_link_b') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <div>
                            <!-- Useful Link C -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="useful_link_c">
                                    {{ __('labels.setting.fields.useful_link_c') }}
                                </label>
                                <input type="text" name="useful_link_c" id="useful_link_c"
                                    value="{{ old('useful_link_c', $settings['useful_link_c']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('useful_link_c') ? 'border-red-500' : '' }}">
                            </div>
                        </div>

                        <div>
                            <!-- Useful Link D -->
                            <div class="w-full px-2 my-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="useful_link_d">
                                    {{ __('labels.setting.fields.useful_link_d') }}
                                </label>
                                <input type="text" name="useful_link_d" id="useful_link_d" value="{{ old('useful_link_d', $settings['useful_link_d']) }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-[var(--default-background)] focus:border-[var(--default-background)] text-sm {{ $errors->has('useful_link_d') ? 'border-red-500' : '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <div class="flex justify-start p-4">
                        <button type="submit" class="bg-black theme-bg text-white rounded-md cursor-pointer px-4 py-2 hover:opacity-50">
                            {{ __('global.update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $('#reset-color').on('click', function() {
            let defaultColorValue = '#00A54F';
            document.getElementById('default_bg_color').value = defaultColorValue;
        });

        function previewImage(id) {
            $(`#delete_btn_${id}`).addClass('d-none');
            $(`#clear_btn_${id}`).removeClass('d-none');
            previewId = `#preview_${id}`;
            $(previewId).attr('src', URL.createObjectURL(event.target.files[0]));
        }

        $(".deleteImage").on("click", function() {
            Swal.fire({
                title: "Are you sure you want to delete?",
                text: "If you delete this, it will be gone forever.",
                icon: "warning",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#FF0000',
                confirmButtonText: 'Yes, delete it!'
            }).then((willDelete) => {
                let key = $(this).data('key');
                if (willDelete.isConfirmed == true) {
                    let url = `{{ route('admin.settings.destroy') }}`;
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: {
                            key: key
                        },
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                let setting = response.setting;
                                $(`#preview_${setting['key']}`).attr('src', setting['value']);
                                // Swal.fire(response.success, {
                                //     position: "top-end",
                                //     icon: "success",
                                //     title: "Your work has been saved",
                                //     showConfirmButton: false,
                                //     timer: 1500
                                // });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
