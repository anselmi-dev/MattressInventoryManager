@props(['products'])

<div {{ $attributes->merge(["class" => "sm:max-w-md"]) }}>
    <div class="combination-products">
        @foreach ($products as $product)
            <div class="combination-products__item">
                <span class="combination-products__code">{{ $product->code }}</span>
                <span class="combination-products__icon">
                    @switch($product->type)
                        @case('cover')
                            <x-icons.cover/>
                            @break
                        @case('base')
                            <x-icons.base/>
                            @break
                        @case('top')
                            <x-icons.top/>
                            @break
                        @default
                    @endswitch
                </span>
                <span class="combination-products__stock">
                    {{ $product->stock }}
                </span>
                <strong class="combination-products__type uppercase">{{ __($product->type ) }}</strong>
                <strong class="combination-products__name uppercase">{{ __($product->name ) }}</strong>
            </div>
        @endforeach
    </div>
</div>