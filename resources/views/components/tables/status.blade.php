@props(['active' => false])

@if ($active)
    <x-heroicon-o-check-circle class="h-5 w-5 shrink-0 text-green-600"/>
@else
    <x-heroicon-o-x-circle class="h-5 w-5 shrink-0 text-red-600"/>
@endif
