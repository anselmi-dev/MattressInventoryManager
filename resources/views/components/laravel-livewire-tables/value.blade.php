<span class="flex gpa-0.5 items-center">
    @isset($icon)
        <x-wireui:icon name="{{ $icon }}"  class="h-4"/>
    @endisset
    <span>{{ $value }}</span>
</span>