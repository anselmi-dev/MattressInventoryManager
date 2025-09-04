<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="{ state: $wire.$entangle(@js($getStatePath())) }"
        {{ $getExtraAttributeBag() }}
    >
        <div
            class="bg-gray-50 sm:rounded-lg dark:bg-gray-800/50 dark:shadow-none dark:outline dark:-outline-offset-1 dark:outline-white/10 flex flex-row gap-2 px-4 py-3 sm:p-4 ">
            <div class="flex justify-center">
                <svg class="w-8 h-8" viewBox="0 0 24 24"><g fill="none"><path stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M12 17v-6"></path><circle cx="1" cy="1" r="1" fill="currentColor" transform="matrix(1 0 0 -1 11 9)"></circle><path stroke="currentColor" stroke-width="1.5" d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2s7.071 0 8.535 1.464C22 4.93 22 7.286 22 12s0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z" opacity=".5"></path></g></svg>
            </div>
            <div class="flex flex-col">
                @if (!empty($getTitle()))
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{!! $getTitle() !!}</h3>
                @endif
                @if (!empty($getDescription()))
                    <div class="text-base text-gray-500 dark:text-gray-400">
                        <p>{!! $getDescription() !!}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-dynamic-component>
