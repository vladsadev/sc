<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Nueva Inspección: <span class="text-yellow-600">{{ $equipment->code }}</span>
            </h2>
            <x-link-btn href="{{ route('equipment.show', $equipment) }}">
                Volver al Equipo
            </x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>
        {{-- Componente Livewire --}}
        @livewire('inspection-form', ['equipment' => $equipment])
    </x-panels.main>
</x-app-layout>
