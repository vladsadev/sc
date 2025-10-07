@props(['machine'])

@php
    $estado= $machine->status;
if($estado === 'operativa'){
    $classes = 'bg-green-300';
}else{
    $classes = 'bg-red-300';
}
@endphp

<div class="bg-white rounded-xl shadow-md border overflow-hidden hover:shadow-lg transition">
    <!-- Imagen -->
    <div class="relative">
        <img
            src="{{ $machine->equipment_img ? asset('storage/' . $machine->equipment_img) : Vite::asset
            ('resources/images/simba1.webp') }}"
            alt="Imagen del equipo"
            class="w-full h-40 object-cover">
        <span class="absolute top-4 left-4 text-blue-main text-sm md:text-base font-semibold px-4 py-1 rounded-full
    shadow {{$classes}}">
        {{__($machine->status)}}
    </span>
    </div>

    <!-- Contenido -->
    <div class="px-4 pt-2 pb-3">
        <div class="flex justify-between items-center">
            <h2 class="text-lg lg:text-xl font-semibold text-gray-900 mb-1">
                <span class="text-yellow-main font-bold"> {{$machine->code}} </span>
            </h2>
            <div>
                <span class="font-bold text-lg">{{$machine->brand}} - {{$machine->model}}</span>
            </div>

        </div>

        <!-- Datos en 1 columna -->
        <hr class="mb-1.5">
        <div class="mb-3 space-y-2">
            <div class="text-sm text-blue-main">
                <span class="font-bold">
                    Tipo de Equipo:
                </span>
                {{$machine->equipmentType->name}}
            </div>
            <hr class="mb-1.5">
            <div class="text-sm text-blue-light">
                <span class="font-bold">
                    Descripción:
                </span>
                {{$machine->equipmentType->description}}
            </div>
            <hr class="mb-1.5">
            <div class="text-sm text-blue-light">
                <span class="font-bold">
                    Ubicación:
                </span>
                {{$machine->location}}
            </div>
        </div>


        <!-- Botone(s) de acción-->
        <div class="flex items-center justify-between pt-2 flex-wrap gap-2">
            <div>
                <x-link-btn variant="secondary" href="{{route('maintenances.create',$machine)}}">Mantenimiento</x-link-btn>
                <x-link-btn variant="secondary" href="{{route('inspection.create',$machine)}}">Inspección</x-link-btn>

{{--                <x-link-btn size="sm" href="{{route('equipment.show',$machine['id'])}}">--}}
{{--                    Inspección--}}
{{--                </x-link-btn>--}}
{{--                <x-link-btn size="sm" href="{{route('equipment.show',$machine['id'])}}">--}}
{{--                   Mantenimiento--}}
{{--                </x-link-btn>--}}
            </div>
            <x-link-btn href="{{route('equipment.show',$machine['id'])}}">
                Ver Más
            </x-link-btn>
        </div>
    </div>
</div>

