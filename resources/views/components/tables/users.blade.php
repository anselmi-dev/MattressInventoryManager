@props(['count' => 0])

<div class="flex items-center">
    @if ($count > 1)
        <img class="object-cover w-6 h-6 -mx-1 border-2 border-white rounded-full dark:border-gray-700 shrink-0" src="{{ asset('images/profile.png') }}" alt="">
        <img class="object-cover w-6 h-6 -mx-1 border-2 border-white rounded-full dark:border-gray-700 shrink-0" src="{{ asset('images/profile.png') }}" alt="">
        <p class="flex items-center justify-center w-6 h-6 -mx-1 text-xs text-blue-600 bg-blue-100 border-2 border-white rounded-full">
            +{{ $count - 1 }}
        </p>
    @elseif($count == 1)
        <img class="object-cover w-6 h-6 -mx-1 border-2 border-white rounded-full dark:border-gray-700 shrink-0" src="{{ asset('images/profile.png') }}" alt="">
        <p class="flex items-center justify-center w-6 h-6 -mx-1 text-xs text-blue-600 bg-blue-100 border-2 border-white rounded-full">
            {{ $count }}
        </p>
    @else
        <img class="opacity-50 object-cover w-6 h-6 -mx-1 border-2 border-white rounded-full dark:border-gray-700 shrink-0" src="{{ asset('images/profile.png') }}" alt="">
        <p class="flex items-center justify-center w-6 h-6 -mx-1 text-xs text-red-600 bg-red-100 border-2 border-white rounded-full">
            {{ $count }}
        </p>
    @endif
</div>
