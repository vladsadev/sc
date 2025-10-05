<x-app-layout>
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <div class="flex items-center mb-6">
            <div class="bg-red-100 rounded-full p-3 mr-4">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Confirmar Eliminación</h1>
                <p class="text-gray-600">Esta acción no se puede deshacer</p>
            </div>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <div class="flex">
                <div class="shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong>¡Atención!</strong> Este equipo tiene registros asociados que también serán eliminados.
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">
                Equipo: <span class="text-blue-600">{{ $equipment->code }}</span>
            </h2>

            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-sm text-gray-700 mb-2">
                    <span class="font-medium">Marca:</span> {{ $equipment->brand }}
                </p>
                <p class="text-sm text-gray-700 mb-2">
                    <span class="font-medium">Modelo:</span> {{ $equipment->model }}
                </p>
                <p class="text-sm text-gray-700">
                    <span class="font-medium">Ubicación:</span> {{ $equipment->location }}
                </p>
            </div>
        </div>

        <div class="border-t border-gray-200 pt-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Registros que serán eliminados:</h3>

            <div class="space-y-3">
                @if($inspectionCount > 0)
                    <div class="flex items-center justify-between bg-red-50 rounded-lg p-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-red-700">Inspecciones</span>
                        </div>
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm">
                    {{ $inspectionCount }} registro(s)
                </span>
                    </div>
                @endif

                @if($maintenanceCount > 0)
                    <div class="flex items-center justify-between bg-red-50 rounded-lg p-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 01-2 2v2a1 1 0 01-1 1H9a1 1 0 01-1-1v-2a2 2 0 01-2-2H5a1 1 0 01-1-1V8a1 1 0 011-1h3a1 1 0 001-1V4z"></path>
                            </svg>
                            <span class="text-sm font-medium text-red-700">Mantenimientos</span>
                        </div>
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm">
                    {{ $maintenanceCount }} registro(s)
                </span>
                    </div>
                @endif

                @if($inspectionCount == 0 && $maintenanceCount == 0)
                    <div class="flex items-center bg-green-50 rounded-lg p-3">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm text-green-700">No hay registros asociados que serán eliminados</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-end">
            <a href="{{ route('equipment.show', $equipment) }}"
               class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-xs bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Cancelar
            </a>

            <form method="POST" action="{{ route('equipment.destroy', $equipment) }}" class="inline">
                @csrf
                @method('DELETE')
                <input type="hidden" name="force_delete" value="1">

                <button type="submit"
                        class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-xs bg-red-600 text-sm font-medium text-white hover:bg-red-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                        onclick="return confirm('¿Estás completamente seguro? Esta acción eliminará permanentemente el equipo y todos sus registros.')">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Sí, Eliminar Permanentemente
                </button>
            </form>
        </div>
    </div>

</x-app-layout>
