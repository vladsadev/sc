@props(['equipment'])

@php
    $estado= $equipment->status;

if($estado === 'operativa'){
    $classes = 'bg-green-300';
}else{

    $classes = 'bg-red-300';
}
@endphp

        <!-- Imagen principal -->
<div class="relative">
    <img src="{{Vite::asset('resources/images/simba1.webp')}}" alt="SIMBA S7D" class="w-full h-72 object-cover">
    <span class="absolute top-4 left-4 text-blue-main text-sm md:text-base font-semibold px-4 py-1 rounded-full
    shadow {{$classes}}">
        {{__($equipment->status)}}
    </span>
</div>

<!-- Contenido -->
<div class="p-6 space-y-8">

    <!-- Encabezado -->
    <div class="flex justify-between">
        <div>
            <h2 class="text-2xl font-bold text-yellow-main">
                Código: {{$equipment->code}}
            </h2>
            <p class="text-gray-600 mt-1 text-sm lg:text-lg"> Marca: {{$equipment->brand}} •
                Modelo:
                {{$equipment->model}} •
                Año:
                {{$equipment->year}}
            </p>
            <p class="text-gray-500 text-sm lg:text-lg mt-1">Ubicación: {{$equipment->location}}</p>
        </div>
        <!--Botones de Acción Administrativa -->
        <div class="flex flex-col gap-2 justify-start items-end text-center">
            <div class="flex gap-2">
                @can('admin-access')
                    <x-link-btn variant="danger" href="{{route('equipment.confirm-delete',$equipment)}}" class="text-center">
                        Borrar
                    </x-link-btn>

                    <x-link-btn variant="danger" href="{{route('equipment.edit',$equipment)}}" class="text-center">Editar
                    </x-link-btn>
                @endcan
            </div>


        </div>
        <form id="delete-form" method="POST" action="{{route('equipment.destroy',$equipment)}}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Acciones de control y servicio-->
    <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Acciones Sobre el equipo</h3>

        <x-link-btn href="{{route('maintenances.create',$equipment)}}">Agendar Mantenimiento</x-link-btn>
        <x-link-btn href="{{route('inspection.create',$equipment)}}">Realizar Inspección</x-link-btn>
    </div>

    <!-- Mantenimiento -->
    <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-3">Mantenimiento</h3>
        <div class="grid grid-cols-1 text-base  text-gray-600">

            <p><span class="font-semibold">Último Mantenimiento:</span> {{ $equipment->last_maintenance?
            $equipment->last_maintenance->format('d-m-Y'):'No Hay registro de Mantenimientos previos'}}

        </div>
    </div>

    <!-- Manuales-->
    {{--    <div>--}}
    {{--        <h3 class="text-xl font-semibold text-gray-800 mb-3">Manuales</h3>--}}
    {{--        --}}
    {{--    </div>--}}

</div>
