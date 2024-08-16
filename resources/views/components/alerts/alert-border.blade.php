@props(['color' => 'indigo', 'title', 'class'])

<div class="{{ $class ?? null }} bg-{{ $color }}-100 border-l-4 border-{{ $color }}-500 text-{{ $color }}-700 px-4 py-1" role="alert">
    @isset($title)
        <p class="font-bold">
            {{ $title }}
        </p>
    @endisset
    <p>
        {{ $slot }}
    </p>
</div>
