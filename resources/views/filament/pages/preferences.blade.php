<x-filament-panels::page>
    <form wire:submit.prevent="submitPreferences">
        {{ $this->form }}
        <x-filament::button type="submit">
            Guardar Preferencias
        </x-filament::button>
    </form>
</x-filament-panels::page>
