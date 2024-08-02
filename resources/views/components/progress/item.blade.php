@props(['first' => false, 'last' => false, 'title', 'description' => null, 'current' => false, 'check' => false])

<li class="relative pb-10">
    @if (!$last)
        <div @class([
            "absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5",
            "bg-indigo-600" => $check,
            "bg-gray-300" => !$check
        ]) aria-hidden="true"></div>
    @endif
    <span class="group relative flex items-start">
        <span class="flex h-9 items-center" aria-hidden="true">
            @if ($check)
                <span class="flex h-9 items-center">
                    <span class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 group-hover:bg-indigo-800">
                        <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                </span>
            @else
                <span class="flex h-9 items-center" aria-hidden="true">
                    <span
                        @class([
                            "relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 bg-gray-100 dark:bg-gray-800",
                            "border-indigo-600" => $current,
                            "border-gray-600" => !$current,
                        ])>
                        <x-loading @class(['hidden' => !$current])></x-loading>
                        <span
                            @class([
                                "h-2.5 w-2.5 rounded-full",
                                'bg-indigo-600' => $current,
                                'bg-gray-600'   => !$current,
                            ])
                        ></span>
                    </span>
                </span>
            @endif
        </span>
        <span class="ml-4 flex min-w-0 flex-col">
            <span class="text-base font-medium text-gray-500 dark:text-white">
                {{ $title }}
            </span>
            <span class="text-xs font-ligth text-gray-500 dark:text-white">
                {{ $description }}
            </span>
        </span>
    </span>
</li>
