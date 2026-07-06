<x-filament::page>
    {{ $this->form }}

    <x-filament::button type="submit" wire:click="save">
        Guardar cambios
    </x-filament::button>
</x-filament::page>
