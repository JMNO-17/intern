<div class="bg-base2 border-t border-gray-200">

   <!-- Main Footer -->
<div class="scroll-mt-12 py-10 px-5 lg:px-20" id="contactus">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Contact Details -->
        <div class="flex-1">
            <ul class="space-y-3 text-black">
                <li class="flex items-center gap-3">
                    <span class="flex items-center justify-center w-9 h-9">
                        <i class="fa-solid fa-house"></i>
                    </span>
                    <a href="https://www.google.com/maps/search/{{ urlencode($settings['address']) }}"
                       target="_blank"
                       class="transition hover:text-white hover:bg-base4 hover:px-3 hover:py-1 hover:rounded-lg">
                        {{ $settings['address'] }}
                    </a>
                </li>

                <li class="flex items-center gap-3">
                    <span class="flex items-center justify-center w-9 h-9">
                        <i class="fa-solid fa-envelope-open"></i>
                    </span>
                    <a href="mailto:{{ $settings['email'] }}"
                       class="transition hover:text-white hover:bg-base4 hover:px-3 hover:py-1 hover:rounded-lg">
                        {{ $settings['email'] }}
                    </a>
                </li>

                <li class="flex items-center gap-3">
                    <span class="flex items-center justify-center w-9 h-9">
                        <i class="fa-solid fa-phone-volume"></i>
                    </span>
                    <a href="tel:{{ $settings['phone'] }}"
                       class="transition hover:text-white  hover:bg-base4 hover:px-3 hover:py-1 hover:rounded-lg">
                        {{ $settings['phone'] }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- Google Map -->
        @if (!empty($settings['google_map']))
            <div class="flex">
                <div class="w-full h-64 sm:h-80 lg:h-64 rounded overflow-hidden shadow-lg">
                    {!! $settings['google_map'] !!}
                </div>
            </div>
        @endif

    </div>
</div>


    <!-- Copyright -->
    <div class="py-4 px-5 lg:px-20 border-t border-gray-200 text-center bg-base3 text-white">
        © {{ __('labels.footer.developed_year') }} Build in Design. {{ __('labels.footer.all_rights_reserved') }}.
        <br> Designed by {{ $settings['site_name'] ?? config('app.name') }}.
    </div>

</div>
