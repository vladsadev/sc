<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detalle de Inspección
                </h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($inspection->status === 'completada')
                        bg-green-100 text-green-800
                    @elseif($inspection->status === 'completada_con_observaciones')
                        bg-yellow-100 text-yellow-800
                    @elseif($inspection->status === 'requiere_atencion_urgente')
                        bg-red-100 text-red-800
                    @else
                        bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $inspection->status)) }}
                </span>
            </div>
            <div class="text-sm text-gray-600">
                {{ $inspection->inspection_date->format('d/m/Y H:i') }}
            </div>
        </div>
    </x-slot>

    <x-panels.main>
        {{-- Header principal --}}
        <div class="px-6 py-4 bg-blue-main border-b border-gray-200">
            <div class="flex justify-between items-center text-white">
                <h3 class="text-lg font-semibold tracking-wide">Reporte de Inspección General</h3>
                <div class="text-right">
                    <div class="text-sm opacity-90">Equipo: <span class="text-yellow-main font-semibold text-base">
                        {{ $inspection->equipment->code }}
                        </span>
                    </div>
                    <div class="font-medium">{{ $inspection->equipment->brand }} {{ $inspection->equipment->model }}</div>
                </div>
            </div>
        </div>
        <x-inspection.horometer-info :inspection="$inspection"/>


        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Columna principal: Elementos de inspección --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- ⚙️ Sección 1: Revisión antes de arrancar --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-blue-light px-6 py-4">
                            <h3 class="flex items-center text-lg font-semibold text-white">
                                <span class="mr-3">⚙️</span> Revisión antes de arrancar
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center justify-between">
                                    <span>Combustible:</span>
                                    <span>{!! $inspection->nivel_combustible_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Aceite motor:</span>
                                    <span>{!! $inspection->nivel_aceite_motor_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Refrigerante:</span>
                                    <span>{!! $inspection->nivel_refrigerante_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Aceite hidráulico:</span>
                                    <span>{!! $inspection->nivel_aceite_hidraulico_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Purgar agua filtro:</span>
                                    <span>{!! $inspection->purgar_agua_filtro_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Polvo válvula vacío:</span>
                                    <span>{!! $inspection->polvo_valvula_vacio_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Correas alternador, ventilador y combustible:</span>
                                    <span>{!! $inspection->correas_alternador_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Filtro de aire:</span>
                                    <span>{!! $inspection->filtro_de_aire_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Reservorio de grasa:</span>
                                    <span>{!! $inspection->reservorio_de_grasa_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Bornes de batería:</span>
                                    <span>{!! $inspection->bornes_de_bateria_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Mangueras de admisión:</span>
                                    <span>{!! $inspection->mangueras_de_admision_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Gatas:</span>
                                    <span>{!! $inspection->gatas_checked ? '✅' : '❌' !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 🔄 Sección 2: Después de arrancar --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-blue-light px-6 py-4">
                            <h3 class="flex items-center text-lg font-semibold text-white">
                                <span class="mr-3">🔄</span> Después de arrancar
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center justify-between">
                                    <span>Pedales de freno:</span>
                                    <span>{!! $inspection->pedales_freno_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Alarma de arranque:</span>
                                    <span>{!! $inspection->alarma_arranque_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Viga y brazo:</span>
                                    <span>{!! $inspection->viga_y_brazo_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Sistema de rimado:</span>
                                    <span>{!! $inspection->sistema_de_rimado_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Sistema de aire:</span>
                                    <span>{!! $inspection->sistema_de_aire_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Sistema de barrido:</span>
                                    <span>{!! $inspection->sistema_de_barrido_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Booster de agua:</span>
                                    <span>{!! $inspection->booster_de_agua_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Regulador de aire + lub:</span>
                                    <span>{!! $inspection->regulador_de_aire_lub_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Carrete manguera agua:</span>
                                    <span>{!! $inspection->carrete_manguera_agua_checked ? '✅' : '❌' !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 🛠️ Sección 3: Inspección general --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-blue-light px-6 py-4">
                            <h3 class="flex items-center text-lg font-semibold text-white">
                                <span class="mr-3">🛠️</span> Inspección general
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center justify-between">
                                    <span>Carrete posicionamiento:</span>
                                    <span>{!! $inspection->carrete_de_posicionamiento_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Válvula avance:</span>
                                    <span>{!! $inspection->valvula_a_avance_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Cable retroceso y tensor:</span>
                                    <span>{!! $inspection->cable_retroceso_y_tensor_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Mesa perforadora:</span>
                                    <span>{!! $inspection->mesa_de_perforadora_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Dowel:</span>
                                    <span>{!! $inspection->dowel_checked ? '✅' : '❌' !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ⚙️ Sección 4: Temas no negociables --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-blue-light px-6 py-4">
                            <h3 class="flex items-center text-lg font-semibold text-white">
                                <span class="mr-3">⚙️</span> Temas no negociables
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div class="flex items-center justify-between">
                                    <span>Freno de servicio:</span>
                                    <span>{!! $inspection->freno_de_servicio_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Freno de parqueo:</span>
                                    <span>{!! $inspection->freno_parqueo_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Controles perforación:</span>
                                    <span>{!! $inspection->controles_perforacion_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Luces delanteras:</span>
                                    <span>{!! $inspection->luces_delanteras_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Alarma de retroceso:</span>
                                    <span>{!! $inspection->alarma_de_retroceso_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Bocina:</span>
                                    <span>{!! $inspection->bocina_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Cinturón de seguridad:</span>
                                    <span>{!! $inspection->cinturon_de_seguridad_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Switch master:</span>
                                    <span>{!! $inspection->switch_master_checked ? '✅' : '❌' !!}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Paradas de emergencia:</span>
                                    <span>{!! $inspection->paradas_de_emergencia_checked ? '✅' : '❌' !!}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 🚨 Averías Reportadas --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-red-700 px-6 py-4">
                            <h3 class="flex items-center text-lg font-semibold text-white">
                                <span class="mr-3">🚨</span>
                                Averías Reportadas
                                <span class="ml-2 bg-white text-red-700 px-2 py-1 rounded-full text-xs font-bold">
                                    {{ $inspection->issues->count() }}
                                </span>
                            </h3>
                        </div>
                        <div class="p-6">
                            @if($inspection->issues->count() > 0)
                                <div class="space-y-4">
                                    @foreach($inspection->issues as $issue)
                                        <div class="border border-gray-200 rounded-lg p-4
                                            @if($issue->severity === 'critica') border-red-500 bg-red-50
                                            @elseif($issue->severity === 'alta') border-orange-500 bg-orange-50
                                            @elseif($issue->severity === 'media') border-yellow-500 bg-yellow-50
                                            @else border-blue-500 bg-blue-50
                                            @endif">

                                            <div class="flex items-start justify-between mb-3">
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-800">{{ $issue->component }}</h4>
                                                    <div class="flex items-center gap-3 mt-1">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                            @if($issue->severity === 'critica') bg-red-600 text-white
                                                            @elseif($issue->severity === 'alta') bg-orange-600 text-white
                                                            @elseif($issue->severity === 'media') bg-yellow-600 text-white
                                                            @else bg-blue-600 text-white
                                                            @endif">
                                                            {{ ucfirst($issue->severity) }}
                                                        </span>
                                                        <span class="text-sm text-gray-600">
                                                            {{ ucfirst(str_replace('_', ' ', $issue->issue_type)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                    @if($issue->status === 'abierto') bg-red-100 text-red-800
                                                    @elseif($issue->status === 'en_proceso') bg-yellow-100 text-yellow-800
                                                    @else bg-green-100 text-green-800
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $issue->status)) }}
                                                </span>
                                            </div>

                                            <div class="text-sm text-gray-700 mb-3">
                                                <strong>Descripción:</strong> {{ $issue->description }}
                                            </div>

                                            <div class="text-xs text-gray-500 mt-2 border-t pt-2">
                                                Reportado el {{ $issue->reported_at->format('d/m/Y H:i') }}
                                                por {{ $issue->user->name }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-lg font-medium">¡Sin averías reportadas!</p>
                                    <p class="text-sm">Esta inspección no registró problemas en ningún componente.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Sidebar: Información adicional --}}
                <div class="space-y-6">

                    {{-- Detalles del equipo --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-blue-lighter px-4 py-3">
                            <h3 class="text-white font-semibold">Detalles del Equipo</h3>
                        </div>
                        <div class="p-4 space-y-2 text-sm">
                            <div><strong>Código:</strong> {{ $inspection->equipment->code }}</div>
                            <div><strong>Marca:</strong> {{ $inspection->equipment->brand }}</div>
                            <div><strong>Modelo:</strong> {{ $inspection->equipment->model }}</div>
                            <div><strong>Año:</strong> {{ $inspection->equipment->year }}</div>
                            <div><strong>Ubicación:</strong> {{ $inspection->equipment->location ?? 'No especificada' }}</div>
                        </div>
                    </div>

                    {{-- Detalles del inspector --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-blue-lighter px-4 py-3">
                            <h3 class="text-white font-semibold">Inspector</h3>
                        </div>
                        <div class="p-4 space-y-2 text-sm">
                            <div><strong>Nombre:</strong> {{ $inspection->user->name }}</div>
                            <div><strong>Fecha inspección:</strong> {{ $inspection->inspection_date->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>

                    {{-- Horómetros --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-blue-lighter px-4 py-3">
                            <h3 class="text-white font-semibold">⏱️ Horómetros</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Motor:</span>
                                <span
                                    class="font-semibold text-gray-800">{{ number_format($inspection->engine_hours, 1) }}h</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Percusión:</span>
                                <span
                                    class="font-semibold text-gray-800">{{ number_format($inspection->percussion_hours, 1) }}h</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-600">Posición:</span>
                                <span
                                    class="font-semibold text-gray-800">{{ number_format($inspection->position_hours, 1) }}h</span>
                            </div>
                        </div>
                    </div>

                    {{-- EPP --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-blue-lighter px-4 py-3">
                            <h3 class="text-white font-semibold">👷 Equipo de Protección Personal</h3>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-center">
                                <span class="text-2xl">
                                    {!! $inspection->epp_complete ? '✅ Completo' : '❌ Incompleto' !!}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Observaciones --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="bg-gray-600 px-4 py-3">
                            <h3 class="text-white font-semibold">📝 Observaciones</h3>
                        </div>
                        <div class="p-4">
                            @if($inspection->observations)
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $inspection->observations }}</p>
                            @else
                                <p class="text-sm text-gray-500 italic">Sin observaciones</p>
                            @endif
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="bg-white rounded-lg shadow-xs border border-gray-200 overflow-hidden">
                        <div class="p-4 space-y-3">
                            <a href="{{ route('equipment.show', $inspection->equipment) }}"
                               class="w-full inline-flex justify-center items-center px-4 py-2 border hover:bg-blue-main
                               hover:text-yellow-light
                               border-gray-300
                               rounded-lg text-gray-700 bg-white transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Volver al Equipo
                            </a>

                            @can('edit inspections')
                                <a href="{{ route('inspection.edit', $inspection) }}"
                                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-blue-600 rounded-lg text-blue-600 bg-white hover:bg-blue-50 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Editar Inspección
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-panels.main>

</x-app-layout>
