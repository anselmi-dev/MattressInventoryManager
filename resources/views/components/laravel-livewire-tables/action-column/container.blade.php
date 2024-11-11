<div {{ $attributes->merge(["class" => "w-full text-right ml-auto relative"]) }}>
    <span class="inline-flex rounded-md border border-gray-400 overflow-hidden | absolute top-[-4px] right-0">
        {{ $slot }}
    </span>
</div>