<div {{ $attributes->merge(["class" => "col-span-full w-full relative my-1 py-1"]) }}>
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-300"></div>
    </div>
    @isset($title)
        <div class="relative flex justify-center">
            <span class="bg-white px-2 text-base text-gray-500 font-bold">
                {{ $title }}
            </span>
        </div>
    @endisset
</div>
