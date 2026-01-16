@extends('layouts.frontend')

@section('content')

    <!-- Hero -->
   <section id="home" class="w-full">
    <img
        src="https://images.pexels.com/photos/572056/pexels-photo-572056.jpeg"
        alt=""
        class="block w-full h-[250px] sm:h-[300px] md:h-[400px] object-cover"
    >
    </section>


    <!-- About Section -->
    <section id="aboutus" class="bg-hero">
        <div class="w-full px-4 sm:px-6 lg:px-20 py-6 lg:py-8">

            @php
                $aboutUs = $abouts->firstWhere('name', 'About Us');
                $aboutWhy = $abouts->firstWhere('name', 'Why Choose Lin Oo?');
            @endphp

            <div class="space-y-8 max-w-[1440px] mx-auto">

                <!-- About Us -->
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold mb-3">
                        {{ $aboutUs->name ?? 'About Us' }}
                        <span>...</span>
                    </h2>

                    <div class="max-w-3xl text-black text-base sm:text-lg  leading-relaxed">
                        {!! $aboutUs->description ?? '' !!}
                    </div>
                </div>

                <!-- Why Choose -->
                <div>
                    <h2 class="text-xl sm:text-2xl font-bold mb-3">
                        {{ $aboutWhy->name ?? 'Why Choose Lin Oo?' }}
                    </h2>

                    <div class="max-w-3xl text-black text-base sm:text-lg leading-relaxed py-2">
                        <ul class="list-disc list-outside pl-5 space-y-2">
                            {!! $aboutWhy->description ?? '' !!}
                        </ul>
                    </div>

                    <p class="max-w-3xl text-black text-base sm:text-lg leading-relaxed mt-4">
                        Established in 2018 in Yangon, Myanmar, Lin Oo has rapidly emerged
                        as a leading provider of electronic services and maintenance...
                    </p>
                </div>

            </div>
        </div>
    </section>






    <!-- Products Section -->


    <section id="product" class="px-4 sm:px-6 lg:px-20 py-6 lg:py-8 bg-base2">

        <h1 class="text-xl sm:text-2xl font-bold mb-6">
            Our Products
        </h1>

       <div class="flex flex-wrap gap-2 justify-center mb-8 text-base md:text-lg">
            @foreach ($sections as $section)
                <a href="{{ url()->current() }}?section_id={{ $section->id }}"
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

                        {{-- SECTION NAME --}}
                        {{-- <p class="text-sm mb-2 text-gray-600">
                        {{ $product->section->name ?? '' }}
                    </p> --}}

                        {{-- FEATURED IMAGE --}}
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


    {{-- Services Section --}}
    <section id="service" class="bg-base1 px-4 sm:px-6 lg:px-20 py-6 lg:py-8">
        <h1 class="text-xl sm:text-2xl font-bold text-center">
            Services
        </h1>

        <p class="py-2 text-center max-w-2xl sm:text-lg mx-auto leading-relaxed">
            At Lin Oo, we offer a comprehensive range of electronic services to
            ensure your home and commercial systems operate at their best.
            Our services include:
        </p>

        <div class="mt-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-5xl mx-auto">
                @foreach ($services as $service)
                    <div
                        class="p-4 rounded shadow-lg hover:shadow-xl transition-shadow duration-300 bg-base3">

                        <h2 class="text-lg font-semibold py-2">
                            {{ $service->name }}
                        </h2>

                        @if ($service->getFirstMedia('service_image'))
                            <img
                                src="{{ $service->getFirstMediaUrl('service_image') }}"
                                class="h-48 w-full object-cover rounded mb-4"
                                alt="{{ $service->name }}"
                            >
                        @endif

                        <ul class="list-disc list-outside pl-6 space-y-2 text-black text-base leading-relaxed">
                            {!! $service->description !!}
                        </ul>

                    </div>
                @endforeach
            </div>
        </div>

        <p class="py-4 text-center max-w-2xl sm:text-lg mx-auto leading-relaxed">
            Our skilled technicians are ready to provide prompt and reliable services
            to keep your electronics in top condition.
            Contact Lin Oo for all your electronic needs today!
        </p>
    </section>






@endsection
