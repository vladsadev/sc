<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800">
                Programar Mantenimiento
            </h2>
            <x-link-btn href="{{ route('equipment.show', $equipment) }}">
                Volver al Equipo
            </x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>
        <x-forms.form method="POST" action="{{ route('maintenances.store') }}" class="max-w-4xl px-3 md:px-2">

            <!-- Campo oculto para equipment_id -->
            <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">

            <h3 class="text-xl font-bold text-blue-main mb-4">Información Básica del Mantenimiento</h3>

            <!-- Información del Equipo (Solo lectura) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                <div>
                    <span class="font-semibold">Código del Equipo</span>
                    <p class="mt-1 text-sm text-yellow-main font-bold">{{ $equipment->code }}</p>
                </div>
                <div>
                    <span class="font-semibold">Tipo de Equipo</span>
                    <p class="mt-1 text-sm text-gray-900">{{ $equipment->equipmentType->name }}</p>
                </div>
                <div>
                    <span class="font-semibold">Marca y modelo </span>
                    <p class="mt-1 text-sm text-gray-900">{{ $equipment->brand }} - {{ $equipment->model }}</p>
                </div>
            </div>

            <!-- Campos principales del mantenimiento -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                <!-- Tipo de Mantenimiento -->
                <x-forms.select label="Tipo de Mantenimiento" name="type" required>
                    <option value="">Seleccionar tipo...</option>
                    <option value="preventivo" selected>Preventivo</option>
                    <option value="correctivo">Correctivo</option>
                    <option value="emergencia">Emergencia</option>
                </x-forms.select>

                <!-- Fecha Programada -->
                <x-forms.input
                    label="Fecha Programada"
                    name="scheduled_date"
                    type="date"
                    value="{{ old('scheduled_date', now()->setTimezone('America/La_Paz')->format('Y-m-d')) }}"
                    required
                />

            </div>

            <!-- Título del mantenimiento -->
            <div class="mb-6">
                <x-forms.input
                        label="Título del Mantenimiento"
                        name="title"
                        value="{{ old('title') }}"
                />
            </div>

            <h3 class="text-xl font-bold text-blue-main mb-4">Detalles</h3>
            <!-- Descripción -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción del Mantenimiento
                </label>
                <textarea
                        name="description"
                        id="description"
                        rows="3"
                        class="w-full border-gray-300 rounded-lg shadow-xs focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Describa el trabajo a realizar ej: se cambiará el aceite de motor, filtros, otros, etc."
                >{{ old('description') }}</textarea>
            </div>

            <x-forms.divider class="bg-yellow-main"/>
            <!-- Duración estimada -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                <x-forms.input
                        label="Duración Estimada para el trabajo (horas)"
                        name="duration_hours"
                        type="number"
                        min="1"
                        placeholder="8"
                        value="{{ old('duration_hours') }}"
                />
            </div>

            <x-forms.divider class="bg-yellow-main"/>

            <!-- Observaciones -->
            <div class="mb-6">
                <label for="observations" class="block text-base font-semibold text-gray-700 mb-1">
                    Observaciones (opcional)
                </label>
                <textarea
                        name="observations"
                        id="observations"
                        rows="3"
                        class="w-full text-left border-gray-300 rounded-lg shadow-xs focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Observaciones adicionales, instrucciones especiales
                    ej: Las ruedas traseras presentan mayor
                    desgaste se puede considerar el cambio de las mismas "
                >{{ old('observations') }}</textarea>
            </div>

            <!-- Información del usuario (solo lectura) -->
            <div class="p-4 bg-blue-50 rounded-lg mb-6">
                <h4 class="text-sm font-medium text-blue-800 mb-2">Programado por:</h4>
                <p class="text-sm text-blue-700">{{ $user->name }} ({{ $user->email }})</p>
                <p class="text-xs text-blue-600">{{ now()->format('d/m/Y H:i:s') }}</p>
            </div>

            <x-forms.divider class="bg-yellow-main"/>

            <!-- Botones de acción -->
            <div class="flex justify-end space-x-3">
                <x-link-btn
                        href="{{ route('equipment.show', $equipment) }}"
                    class="bg-gray-500 hover:bg-gray-600"
                >
                    Cancelar
                </x-link-btn>
                <x-forms.button class="cursor-pointer bg-blue-600 hover:bg-blue-700">
                    Programar Mantenimiento
                </x-forms.button>
            </div>
        </x-forms.form>
    </x-panels.main>
</x-app-layout>
