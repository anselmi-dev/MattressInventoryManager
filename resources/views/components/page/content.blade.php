<div {{ $attributes->merge(["class" => "bg-white dark:bg-gray-800 shadow-sm rounded-lg"]) }}>
    <div class="p-3 lg:p-6 text-gray-900 dark:text-gray-100 rounded-lg">
        {{ $slot }}
    </div>
</div>
