<form {{ $attributes->merge(['class' => 'space-y-12']) }}>

    {{ $slot }}

    @isset($actions)
        <div class="col-span-full flex flex-wrap gap-1 w-full justify-end">
            {{ $actions }}
        </div>
    @endisset
</form>