@props(['products'])

<div {{ $attributes->merge(["class" => "sm:max-w-md"]) }}>
    <div class="combination-products">
        @foreach ($products as $product)
            <div class="combination-products__item">
                <span class="combination-products__code">{{ $product->code }}</span>
                <span class="combination-products__icon">
                    @switch($product->type)
                        @case('ALMOHADA')
                            <x-icons.cover/>
                            @break
                        @case('BASE')
                            <x-icons.base/>
                            @break
                        @case('FUNDA')
                            <x-icons.top/>
                            @break
                        @default
                        <x-icons.top/>
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