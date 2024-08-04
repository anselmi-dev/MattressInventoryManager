<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
    <div>
        <label for="username" class="block font-medium leading-6 text-gray-900">
            {{ $label }}
        </label>
        @isset($description)
            <span>
                {!! $description !!}
            </span>
        @endisset
    </div>

    <div class="mt-2 sm:col-span-2 sm:mt-0">
        {{ $slot }}
    </div>
</div>
