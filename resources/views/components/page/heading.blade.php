@props(['title', 'description' => null, 'actions' => null, 'breadcrumbs' => null])

<div class="mx-auto w-full">
    @if ($breadcrumbs)
        {{ Breadcrumbs::render($breadcrumbs) }}
    @endif

    @isset($title)    
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="min-w-0 flex-1">
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    {{ $title }}
                </h1>
                
                @if ($description)
                    <p class="mt-2 leading-none text-gray-700">
                        {{ $description }}
                    </p>
                @endif
            </div>
            
            @if ($actions)
                {{ $actions }}
            @endif
        </div>
    @endisset
</div>
