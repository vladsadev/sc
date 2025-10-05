<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Malla de Perforaciones') }}
        </h2>
    </x-slot>

    <!-- Vista de Detalle de la Malla (Solo una) -->
    @livewire('malla-detail')
</x-app-layout>
