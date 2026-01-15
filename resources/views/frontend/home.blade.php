@extends('layouts.frontend')

@section('content')

    <!-- Hero -->
    <section>
        <img src="https://images.pexels.com/photos/885944/pexels-photo-885944.jpeg"
            class="block w-full h-[400px] object-cover" />
    </section>

    <!-- About Section -->
    <section>
        <div class="max-w-7xl mx-auto py-8 px-4">

            @php
                $aboutUs = $abouts->firstWhere('name', 'About Us');
                $aboutWhy = $abouts->firstWhere('name', 'Why Choose Lin Oo?');
            @endphp

            <div class="space-y-10">
                <div>
                    <h2 class="text-2xl font-bold mb-3">
                        {{ $aboutUs->name ?? 'About Us' }}
                    </h2>
                    <div class="text-gray-700">
                        {!! $aboutUs->description ?? '' !!}
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold mb-3">
                        {{ $aboutWhy->name ?? 'Why Choose Lin Oo?' }}
                    </h2>
                    <div class="text-gray-700">
                        {!! $aboutWhy->description ?? '' !!}
                    </div>
                </div>
            </div>

        </div>
    </section>





    <!-- Products Section -->


    <section class="px-5 lg:px-20 py-8 bg-base2">

        <h1 class="text-2xl font-bold mb-6">
            Our Products
        </h1>

        <div class="flex gap-4 mb-8">
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
    <section class="px-5 lg:px-20 py-8 bg-base1">
        <h1 class="text-2xl font-bold">
            Services
        </h1>
        <p class="py-2">
            At Lin Oo, we offer a comprehensive range of electronic services to
            ensure your home and commercial systems operate at their best.
            <br />
            Our services include:
        </p>
        <div class="flex justify-center py-0 my-0 mx-0">
            <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-6 text-center ">
                @foreach ($services as $service)
                    <div
                        class="p-2 border border-gray-1px rounded shadow hover:shadow-lg transition-shadow duration-300 bg-base3 w-[400px] h-[420px]">

                        {{-- SERVICE NAME --}}
                        <h2 class="text-lg font-semibold py-2 font-[24px]">{{ $service->name }}</h2>

                        {{-- SERVICE IMAGE --}}
                        @if ($service->getFirstMedia('service_image'))
                            <img src="{{ $service->getFirstMediaUrl('service_image') }}"
                                class="px-4 h-48 w-full object-cover rounded" alt="{{ $service->name }}">
                        @endif

                        {{-- SERVICE DESCRIPTION --}}
                        <div class="text-black py-2 font-[16px]">
                            {!! $service->description !!}
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

        <p class="py-2">
            Our skilled technicians are ready to provide prompt and reliable services to keep your electronics in top
            condition.
            Contact Lin Oo for all your electronic needs today!
        </p>
    </section>



@endsection
