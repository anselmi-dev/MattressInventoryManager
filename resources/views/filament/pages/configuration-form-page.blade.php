<x-filament-panels::page>
    <form wire:submit="submit" class="space-y-4">

        {{ $this->form }}

        <div class="flex items-center justify-end mt-10">
            <x-filament::actions :actions="$this->getFormActions()" />
        </div>
    </form>
</x-filament-panels::page>
