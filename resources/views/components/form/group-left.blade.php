<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-3">
    <div>
        <label class="block font-medium leading-6 text-gray-900">
            {{ $label }}
        </label>
        
        @isset($description)
            <div class="leading-2 text-sm text-gray-400">
                {!! $description !!}
            </div>
        @endisset
    </div>

    <div class="mt-2 sm:col-span-2 sm:mt-0">
        {{ $slot }}
    </div>
</div>
