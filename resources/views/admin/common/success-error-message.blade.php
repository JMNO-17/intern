@php

    $colors = [
        'success' => [
            'bg' => 'custom-bg',
            // 'bg' => 'bg-green-500',
            'border' => 'border-green-400',
            'text' => 'text-white',
        ],
        'error' => [
            'bg' => 'bg-red-100',
            'border' => 'border-red-400',
            'text' => 'text-red-700',
        ],
    ];
    $color = $colors[$type] ?? $colors['success'];
    $timeout = $timeout ?? 4000;
@endphp

<div class="w-full p-2">
    <div class="flash-message {{ $color['bg'] }} {{ $color['border'] }} {{ $color['text'] }} px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">{{ $message }}</strong>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 {{ $color['text'] }}" onclick="this.parentElement.remove()" aria-label="Close">
            <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 00-1.414 1.414L8.586 8.586 5.652 11.52a1 1 0 101.414 1.414L10 9.828l2.934 2.934a1 1 0 001.414-1.414L11.414 8.586l2.934-2.934z"/>
            </svg>
        </button>
    </div>
</div>

<script>
    setTimeout(() => {
        document.querySelectorAll('.flash-message').forEach(el => el.style.display = 'none');
    }, {{ $timeout }}); // hide after 4 seconds
</script>
