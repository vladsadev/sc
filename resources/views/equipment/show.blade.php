<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl">
                Editar: <span class="text-yellow-main">{{ $equipment->equipmentType->name . ' '.$equipment->model}}  </span>
            </h2>
            <x-link-btn href="{{route('equipment.index')}}">Volver</x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>

        <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">

            <x-machine.machine :$equipment/>
            <x-equipment.horometer-status :equipment="$equipment" />

        </div>

    </x-panels.main>

</x-app-layout>
