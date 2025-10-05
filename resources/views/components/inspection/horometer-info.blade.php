<!-- resources/views/components/inspection/horometer-info.blade.php -->
<div class="bg-white rounded-lg shadow-xs border border-gray-200 p-4">
    <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Lectura de Horómetros
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Horas del Motor -->
        <div class="bg-gray-50 rounded-lg p-3">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Motor</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($inspection->engine_hours, 1) }}
                        <span class="text-sm text-gray-500">hrs</span>
                    </p>
                    @if($inspection->engine_hours_worked > 0)
                        <p class="text-xs text-green-600 mt-1">
                            +{{ number_format($inspection->engine_hours_worked, 1) }} desde última inspección
                        </p>
                    @endif
                </div>
                <div class="text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Horas de Percusión -->
        <div class="bg-gray-50 rounded-lg p-3">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Percusión</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($inspection->percussion_hours, 1) }}
                        <span class="text-sm text-gray-500">hrs</span>
                    </p>
                    @if($inspection->percussion_hours_worked > 0)
                        <p class="text-xs text-green-600 mt-1">
                            +{{ number_format($inspection->percussion_hours_worked, 1) }} desde última inspección
                        </p>
                    @endif
                </div>
                <div class="text-orange-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Horas de Posicionamiento -->
        <div class="bg-gray-50 rounded-lg p-3">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600">Posicionamiento</p>
                    <p class="text-2xl font-bold text-gray-800">
                        {{ number_format($inspection->position_hours, 1) }}
                        <span class="text-sm text-gray-500">hrs</span>
                    </p>
                    @if($inspection->position_hours_worked > 0)
                        <p class="text-xs text-green-600 mt-1">
                            +{{ number_format($inspection->position_hours_worked, 1) }} desde última inspección
                        </p>
                    @endif
                </div>
                <div class="text-purple-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas adicionales si hay inspección previa -->
{{--    @if($inspection->previousInspection())--}}
{{--        <div class="mt-4 pt-4 border-t border-gray-200">--}}
{{--            <h4 class="text-sm font-medium text-gray-700 mb-2">Promedio diario desde última inspección</h4>--}}
{{--            <div class="grid grid-cols-3 gap-4 text-center">--}}
{{--                <div>--}}
{{--                    <p class="text-xs text-gray-600">Motor</p>--}}
{{--                    <p class="font-semibold">{{ number_format($inspection->average_hours_per_day['engine'], 1) }} hrs/día</p>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <p class="text-xs text-gray-600">Percusión</p>--}}
{{--                    <p class="font-semibold">{{ number_format($inspection->average_hours_per_day['percussion'], 1) }} hrs/día</p>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <p class="text-xs text-gray-600">Posicionamiento</p>--}}
{{--                    <p class="font-semibold">{{ number_format($inspection->average_hours_per_day['position'], 1) }} hrs/día</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
</div>
