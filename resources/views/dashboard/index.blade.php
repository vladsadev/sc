<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Panel Principal') }}
        </h2>
    </x-slot>

    <x-panels.main>

        <!-- Estadísticas Generales -->
        <x-description-heading>Resumen General</x-description-heading>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 md:gap-8 mb-8">
            <!-- Operativas -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Operativas</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['operational'] }}</p>
                    </div>
                </div>
            </div>

            <!-- En Mantenimiento -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">En Mantenimiento</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['in_maintenance'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Fuera de Servicio -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Fuera de Servicio</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['out_of_service'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Flota -->
            <div class="bg-white rounded-xl shadow-xs border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Flota</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_fleet'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalle por Tipo de Máquina -->
        <x-description-heading>Detalle por Tipo de Máquina</x-description-heading>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @forelse($equipmentTypeDetails as $typeDetail)
                <div
                        class="bg-white rounded-xl shadow-xs border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                    <!-- Header del tipo de equipo -->
                    <div class="bg-linear-to-r {{ $typeDetail['gradient_class'] }} px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="{{ $typeDetail['icon_class'] ?? 'fas fa-cog' }} text-white text-lg"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-white">{{ $typeDetail['type_name'] }}</h3>
                                    <p class="text-amber-100 text-sm">{{ $typeDetail['total_equipment'] }} equipos</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-white">{{ $typeDetail['total_equipment'] }}</div>
                                <div class="text-amber-100 text-xs">Total</div>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles del estado -->
                    <div class="p-6">
                        <div class="space-y-3">
                            <!-- Operativas -->
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 flex items-center">
                                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                    Operativas:
                                </span>
                                <span class="font-medium text-green-600">{{ $typeDetail['operational'] }}</span>
                            </div>

                            <!-- Mantenimiento -->
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 flex items-center">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                                    Mantenimiento:
                                </span>
                                <span class="font-medium text-yellow-600">{{ $typeDetail['maintenance'] }}</span>
                            </div>

                            <!-- Fuera de servicio -->
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 flex items-center">
                                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                    Fuera de servicio:
                                </span>
                                <span class="font-medium text-red-600">{{ $typeDetail['out_of_service'] }}</span>
                            </div>
                        </div>

                        <!-- Información de última inspección -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="text-xs text-gray-500 mb-2">Última inspección</div>
                            @if($typeDetail['last_inspection_hours_ago'])
                                @if($typeDetail['last_inspection_hours_ago'] < 24)
                                    <div class="text-sm font-medium text-green-600">
                                        Hace {{ number_format($typeDetail['last_inspection_hours_ago'], 2) }} horas
                                    </div>
                                @elseif($typeDetail['last_inspection_hours_ago'] < 168)
                                    {{-- 7 días --}}
                                    <div class="text-sm font-medium text-yellow-600">
                                        Hace {{ round($typeDetail['last_inspection_hours_ago'] / 24) }} días
                                    </div>
                                @else
                                    <div class="text-sm font-medium text-red-600">
                                        Hace {{ round($typeDetail['last_inspection_hours_ago'] / 24) }} días
                                        <span class="text-xs block">⚠️ Requiere atención</span>
                                    </div>
                                @endif
                            @else
                                <div class="text-sm font-medium text-red-600">
                                    Sin inspecciones registradas
                                    <span class="text-xs block">⚠️ Requiere inspección</span>
                                </div>
                            @endif
                        </div>

                        <!-- Botón de acción opcional -->
                        <div class="mt-4">
                            <a href="{{ route('equipment.index', ['type' => $typeDetail['type_id']]) }}"
                               class="text-sm text-blue-600 hover:text-blue-800 font-medium inline-flex items-center">
                                Ver equipos
                                <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-gray-500">
                    <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                    <p>No hay tipos de equipos configurados</p>
                    <a href="{{ route('equipment.create') }}" class="text-blue-600 hover:underline">Agregar primer equipo</a>
                </div>
            @endforelse
        </div>

        <!-- Sección de alertas (opcional) -->
        @if($stats['in_maintenance'] > 0 || $stats['out_of_service'] > 0)
            <div class="mt-8">
                <x-description-heading>Alertas del Sistema</x-description-heading>
                <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="shrink-0">
                            <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-700">
                                <strong>Considerar:</strong>
                                @if($stats['in_maintenance'] > 0)
                                    {{ $stats['in_maintenance'] }} equipo(s) en mantenimiento.
                                @endif
                                @if($stats['out_of_service'] > 0)
                                    {{ $stats['out_of_service'] }} equipo(s) fuera de servicio.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="border border-yellow-main mt-5 mb-3"></div>

        <!-- Sección para la importación y exportación  -->
        <div class="mx-auto max-w-7xl">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Importar y Exportar Inspecciones</h2>
            <p class="italic">La importación será exitosa solo si los equipos existen y coinciden en sus características.</p>

            <div class="py-4 space-x-2.5">
                <x-link-btn href="{{route('export.inspections')}}">Exportar</x-link-btn>
                <x-link-btn href="{{route('import.form')}}" variant="outline-solid">Importar</x-link-btn>
            </div>
        </div>

    </x-panels.main>

    <!-- Scripts adicionales para funcionalidades dinámicas -->
    @push('scripts')
        <script>
            // Función para actualizar datos en tiempo real (opcional)
            function refreshDashboard() {
                // Implementar aquí llamada AJAX si es necesario
                console.log('Actualizando dashboard...');
            }

            // Auto-refresh cada 5 minutos (opcional)
            // setInterval(refreshDashboard, 300000);
        </script>
    @endpush
</x-app-layout>
