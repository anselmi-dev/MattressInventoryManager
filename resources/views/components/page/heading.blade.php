@props(['title', 'description' => null, 'actions' => null, 'breadcrumbs' => null, 'model' => null])

<div class="mx-auto w-full">
    @if ($breadcrumbs)
        @if ($model)
            {{ Breadcrumbs::render($breadcrumbs, $model) }}
        @else
            {{ Breadcrumbs::render($breadcrumbs) }}
        @endif
    @endif

    @isset($title)    
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="min-w-0 flex-1">
                <h1 @class([
                    "tracking-tight text-gray-900",
                    'text-3xl sm:text-4xl font-bold mt-2' => !$attributes->has('md'),
                    'text-xl sm:text-2xl font-normal' => $attributes->has('md')
                ])>
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
