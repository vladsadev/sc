<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-items-start gap-1">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nueva Inspección:') }}
            </h2>
            <span class="text-base"> {{$equipment->brand .' ' .$equipment->model}}</span>
        </div>
    </x-slot>

    <x-panels.main>
        {{--  header--}}
        <div class="px-6 py-4 bg-blue-light border-b border-gray-200">
            <div class="flex justify-between items-center text-gray-200">
                <h3 class="text-lg font-semibold tracking-wide">Lista de Inspección General</h3>
                <span class="text-sm md:text-base lg:text-lg tracking-wider">Fecha: {{ date('d/m/Y H:i') }}</span>
            </div>
        </div>
        <!-- Formulario Principal de Inspección -->
        <div class="shadow-xl rounded-lg overflow-hidden">
            <form id="inspectionForm"
                  action="{{ route('inspection.store') }}"
                  method="POST"
                  class="space-y-6">
                @csrf

                <!-- Campo oculto para el equipment_id -->
                <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

                <div class="grid grid-1 bg-white p-4 gap-4 md:grid-cols-5">
                    <!-- Lado izquierdo -->
                    <div class="md:col-span-3">
                        <!-- Items de Inspección -->
                        <div class="space-y-3">
                            @php
                                $inspectionItems = [
                                    'cuchara' => 'Revisar el estado de la cuchara',
                                    'llantas' => 'Revisar el estado de las llantas',
                                    'articulacion' => 'Revisar engrase en la articulación central superior e inferior',
                                    'cilindro' => 'Revisar engrase en cilindro de dirección',
                                    'botellones' => 'Revisar engrase en los botellones de levante y volteo',
                                    'zbar' => 'Revisar engrase en Z-BAR',
                                    'dogbone' => 'Revisar engrase en DOG-BONE',
                                    'brazo' => 'Revisar engrase en el brazo/puño de cuchara',
                                    'tablero' => 'Verificar estado del tablero del control y display',
                                    'extintores' => 'Revisar extintores y verificar que esté cargado'
                                ];
                            @endphp

                            @foreach($inspectionItems as $key => $item)
                                <div
                                    class="inspection-item flex items-center justify-between p-4 rounded-lg border border-gray-200 hover:border-yellow-300 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <input type="checkbox"
                                               id="{{ $key }}"
                                               name="{{ $key }}"
                                               class="inspection-check w-5 h-5 text-yellow-600 border-gray-300 rounded-sm focus:ring-yellow-500"
                                               data-item="{{ $item }}">
                                        <label for="{{ $key }}" class="text-gray-700 font-medium">{{ $item }}</label>
                                    </div>
                                    <button type="button"
                                            class="issue-btn text-red-500 hover:text-red-700 p-2 rounded-full hover:bg-red-50 transition-colors hidden"
                                            data-target="{{ $key }}"
                                            data-item="{{ $item }}">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Lado derecho-->
                    <div class="md:col-span-2 space-y-6">

                        <!-- Detalles de la Máquina-->
                        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                            <div class="bg-yellow-600 px-4 py-3">
                                <h3 class="text-white font-semibold">Detalles del Equipo</h3>
                            </div>
                            <div class="p-4">
                                <p class="text-gray-600 mt-1 text-sm lg:text-base">
                                        <span class="font-bold text-base">
                                        Código: {{$equipment->code}} •
                                        </span>
                                    Marca: {{$equipment->brand}} •
                                    Modelo:
                                    {{$equipment->model}} •
                                    Año:
                                    {{$equipment->year}} •
                                    Ubicación: {{$equipment->location}}
                                </p>
                            </div>
                        </div>

                        <!-- Detalles del Inspector -->
                        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                            <div class="bg-yellow-600 px-4 py-3">
                                <h3 class="text-white font-semibold">Detalles del Inspector</h3>
                            </div>
                            <div class="p-4">
                                <div>
                                    <p class="text-gray-600 mt-1 text-sm lg:text-base">
                                        <span class="font-bold text-base">
                                        Nombre: {{$user->name}}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Panel de Seguridad -->
                        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                            <div class="bg-blue-light px-4 py-3">
                                <h3 class="text-white font-semibold">Equipo de Protección - Uso Obligatorio</h3>
                            </div>
                            <div class="p-4">
                                <div class="text-center flex p-2 mb-2">
                                    <!-- EPP IMG -->
                                    <div
                                        class="w-1/2">
                                        <div class="w-24 h-24 bg-blue-100 rounded-full">
                                            <img class="" src="{{Vite::asset('resources/images/eppSimba.png')}}" alt="epp">
                                        </div>
                                    </div>
                                    <div class=" text-left text-blue-main font-semibold">
                                        <ul class="list-disc">
                                            <li>Casco</li>
                                            <li>Botas</li>
                                            <li>Guantes</li>
                                            <li>Chaleco</li>
                                        </ul>
                                    </div>
                                </div>
                                <x-forms.checkbox description="Sí" label="Cumple con todos los EPP" name="epp"/>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observaciones Generales -->
                <div class="mt-6">
                    <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">Observaciones
                        Generales</label>
                    <textarea id="observaciones"
                              name="observaciones"
                              rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-xs focus:border-yellow-500 focus:ring-yellow-500"
                              placeholder="Ingrese observaciones adicionales sobre la inspección..."></textarea>
                </div>

                <!-- En la sección de botones de acción -->
                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <div class="flex items-center space-x-4">
                        <!-- Progreso existente -->
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <span>Progreso:</span>
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="progress-bar bg-yellow-600 h-2 rounded-full transition-all duration-300"
                                     style="width: 0%"></div>
                            </div>
                            <span class="progress-text">0/10</span>
                        </div>

                        <!-- Contador de problemas (NUEVO) -->
                        <div class="flex items-center space-x-2 text-sm text-red-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span>Problemas: <span class="issue-counter font-bold">0</span></span>
                        </div>
                    </div>

                    <div class="flex space-x-3">
                        <x-link-btn href="#">Cancelar</x-link-btn>
                        <x-forms.button>Confirmar Inspección</x-forms.button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal para Reportar Problemas -->
        <x-modals.inspection-problem/>
    </x-panels.main>
</x-app-layout>
