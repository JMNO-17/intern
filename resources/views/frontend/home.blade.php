@extends('layouts.frontend')
@section('content')
    <section>
        <!-- Hero Image -->
        <img src="https://images.pexels.com/photos/885944/pexels-photo-885944.jpeg" alt=""
            class="block w-full h-[400px] object-cover" />
    </section>
    
    <section>

        <!-- Content Container -->
        <div class="max-w-7xl mx-auto my-12 px-4 sm:px-6 lg:px-8">
            @php
                $abouts = $abouts ?? collect();
                $aboutUs = $abouts->firstWhere('name', 'About Us');
                $aboutWhy = $abouts->firstWhere('name', 'Why Choose Lin Oo?');
            @endphp

            <div class="space-y-10">
                <!-- About Us Section -->
                <div>
                    <h2 class="text-2xl font-bold mb-3">
                        {{ $aboutUs->name ?? 'About Us' }}
                    </h2>
                    <div class="mt-2 text-lg text-gray-700 leading-relaxed">
                        {!! $aboutUs->description ?? '' !!}
                    </div>
                </div>

                <!-- Why Choose Us Section -->
                <div>
                    <h2 class="text-2xl font-bold mb-3">
                        {{ $aboutWhy->name ?? 'Why Choose Lin Oo?' }}
                    </h2>
                    <div class="mt-2 text-gray-700 leading-relaxed">
                        {!! $aboutWhy->description ?? '' !!}
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="px-5 lg:px-20 bg-gray-200">
        <div class="p-32 justify-center text-center font-bold text-2xl">
            Contents are here.
        </div>
    </section>
@endsection
