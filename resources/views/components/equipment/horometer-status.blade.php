<!-- resources/views/components/equipment/horometer-status.blade.php -->
<div class="bg-linear-to-r from-blue-50 to-indigo-50 rounded-lg shadow-xs border border-blue-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-xl font-bold text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Estado Actual de Horómetros
        </h3>
        @if($equipment->inspections->count() > 0)
            <span class="text-sm text-gray-500">
                Última actualización: {{ $equipment->inspections->first()->inspection_date->diffForHumans() }}
            </span>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Motor -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 font-medium">Motor</span>
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900">
                {{ number_format($equipment->engine_hours ?? 0, 1) }}
                <span class="text-base font-normal text-gray-500">hrs</span>
            </div>
        </div>

        <!-- Percusión -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 font-medium">Percusión</span>
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900">
                {{ number_format($equipment->percussion_hours ?? 0, 1) }}
                <span class="text-base font-normal text-gray-500">hrs</span>
            </div>
        </div>

        <!-- Posicionamiento -->
        <div class="bg-white rounded-lg p-4 border border-gray-200">
            <div class="flex items-center justify-between mb-2">
                <span class="text-gray-600 font-medium">Posicionamiento</span>
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div class="text-3xl font-bold text-gray-900">
                {{ number_format($equipment->position_hours ?? 0, 1) }}
                <span class="text-base font-normal text-gray-500">hrs</span>
            </div>
        </div>
    </div>
</div>
