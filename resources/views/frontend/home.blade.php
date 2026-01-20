@extends('layouts.frontend')

@section('content')

    @php
        $heroAbout = $abouts->firstWhere('section.name', 'Home');
        $aboutUs = $abouts->firstWhere('name', 'About Us');
        $aboutWhy = $abouts->firstWhere('name', 'Why Choose Lin Oo?');
    @endphp
    <!-- Hero (image from About Us CRUD) -->

    <section id="home" class="w-full scroll-mt-12">
        @if ($heroAbout && $heroAbout->getFirstMedia('about_image'))
            <img
            src="{{ $heroAbout->getFirstMediaUrl('about_image', 'original') }}"
            alt="{{ $heroAbout->name }}"
            class="block w-full h-[250px] sm:h-[300px] md:h-[400px] object-cover"
            loading="eager"
        >
        @endif
    </section>




    <!-- About Section -->
    <section id="aboutus" class="scroll-mt-12 bg-hero">
        <div class="w-full px-4 sm:px-6 lg:px-20 py-6 lg:py-8">



            <div class="space-y-8 max-w-[1440px] mx-auto">

                <div>
                    <h2 class="text-xl sm:text-2xl font-bold mb-3">
                        {{ $aboutUs->name ?? 'About Us' }}
                    </h2>

                    <div class="max-w-3xl text-black text-base sm:text-lg leading-relaxed">
                        {!! $aboutUs->description ?? '' !!}
                    </div>
                </div>

                <div>
                    <h2 class="text-xl sm:text-2xl font-bold mb-3">
                        {{ $aboutWhy->name ?? 'Why Choose Lin Oo?' }}
                    </h2>

                    <div class="max-w-3xl text-black text-base sm:text-lg leading-relaxed py-2">
                        <ul class="list-disc list-outside pl-5 space-y-2">
                            {!! $aboutWhy->description ?? '' !!}
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Products Section -->
    <section id="product" class="scroll-mt-12 px-4 sm:px-6 lg:px-20 py-6 lg:py-8 bg-base2">

        <h1 class="text-xl sm:text-2xl font-bold mb-6 text-center">
            Our Products
        </h1>

        <div class="flex flex-wrap gap-2 justify-center mb-8 text-base md:text-lg">
            @foreach ($sections as $section)
                <a href="{{ url()->current() }}?section_id={{ $section->id }}#product"
                    class="px-4 py-2 rounded
               {{ request('section_id') == $section->id ? 'bg-base4 text-white' : 'hover:bg-base4 hover:text-white' }}">
                    {{ $section->name }}
                </a>
            @endforeach
        </div>

        @if ($products->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="p-2">
                        @if ($product->getFirstMedia('featured_image'))
                            <img src="{{ $product->getFirstMediaUrl('featured_image') }}"
                                class="h-48 w-full object-cover rounded mb-3" alt="{{ $product->name }}">
                        @else
                            <div class="h-48 w-full bg-gray-200 flex items-center justify-center rounded mb-3">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </section>

    <!-- Services Section -->
    <section id="service" class="scroll-mt-12 bg-base1 px-4 sm:px-6 lg:px-20 py-6 lg:py-8">
        <h1 class="text-xl sm:text-2xl font-bold text-center">
            Services
        </h1>

        <p class="py-2 text-center max-w-2xl sm:text-lg mx-auto leading-relaxed">
            At Lin Oo, we offer a comprehensive range of electronic services to ensure your
            home and commercial systems operate at their best.
        </p>

        <div class="mt-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-5xl mx-auto">
                @foreach ($services as $service)
                    <div class="p-4 rounded shadow-lg hover:shadow-xl transition bg-base3">
                        <h2 class="text-lg font-semibold py-2">
                            {{ $service->name }}
                        </h2>

                        @if ($service->getFirstMedia('service_image'))
                            <img src="{{ $service->getFirstMediaUrl('service_image') }}"
                                class="h-48 w-full object-cover rounded mb-4" alt="{{ $service->name }}">
                        @endif

                        <div class="quill-content text-black text-base leading-relaxed">
                            {!! $service->description !!}
                        </div>


                    </div>
                @endforeach
            </div>
        </div>

    </section>

@endsection
