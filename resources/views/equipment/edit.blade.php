<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Editar: ') }} <span class="text-yellow-main">{{ $equipment->equipmentType->name . ' ' . $equipment->model }}</span>
            </h2>

            <x-link-btn href="{{ route('equipment.show', $equipment) }}">Volver</x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>

        <x-forms.form method="POST" action="{{ route('equipment.update', $equipment) }}" enctype="multipart/form-data" class="max-w-4xl px-3 md:px-2">
            @method('PATCH')

            <h3 class="text-xl font-bold text-blue-main mb-4">Campos Obligatorios</h3>

            <!-- Información básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <x-forms.input
                    label="Código"
                    name="code"
                    placeholder="EXC-001"
                    value="{{ old('code', $equipment->code) }}"
                    required
                />

                <x-forms.input
                    label="Marca"
                    name="brand"
                    placeholder="Caterpillar"
                    value="{{ old('brand', $equipment->brand) }}"
                    required
                />

                <x-forms.input
                    label="Modelo"
                    name="model"
                    placeholder="S7D"
                    value="{{ old('model', $equipment->model) }}"
                    required
                />

                <x-forms.input
                    label="Año"
                    name="year"
                    type="number"
                    min="1990"
                    max="{{ date('Y') + 1 }}"
                    placeholder="2024"
                    value="{{ old('year', $equipment->year) }}"
                    required
                />
            </div>

            <!-- Estado -->
            <div class="mb-4">
                <x-forms.select label="Estado" name="status" required>
                    <option value="operativa" {{ old('status', $equipment->status) == 'operativa' ? 'selected' : '' }}>Operativa</option>
                    <option value="mantenimiento" {{ old('status', $equipment->status) == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento</option>
                    <option value="inactiva" {{ old('status', $equipment->status) == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                </x-forms.select>
            </div>

            <!-- Ubicación -->
            <div class="mb-4">
                <x-forms.select label="Ubicación" name="location" required>
                    <option value="">Seleccione una ubicación</option>
                    <option value="Interior mina" {{ old('location', $equipment->location) == 'Interior mina' ? 'selected' : '' }}>Interior Mina</option>
                    <option value="Exterior mina" {{ old('location', $equipment->location) == 'Exterior mina' ? 'selected' : '' }}>Exterior Mina</option>
                    <option value="Área de Mantenimiento" {{ old('location', $equipment->location) == 'Área de Mantenimiento' ? 'selected' : '' }}>Área de Mantenimiento</option>
                    <option value="Apartada de la Empresa" {{ old('location', $equipment->location) == 'Apartada de la Empresa' ? 'selected' : '' }}>Apartada de la Empresa</option>
                </x-forms.select>
            </div>

            <!-- Tipo de Equipo -->
            <div class="mb-4">
                <x-forms.select label="Tipo de Equipo" name="equipment_type_id" required>
                    <option value="">Seleccione un tipo</option>
                    @foreach($eTypes as $type)
                        <option value="{{ $type->id }}" {{ old('equipment_type_id', $equipment->equipment_type_id) == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </x-forms.select>
            </div>

            <!-- Especificaciones Técnicas (Opcionales) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-forms.select label="Tipo de Combustible" name="fuel_type">
                    <option value="">Seleccione (opcional)</option>
                    <option value="diesel" {{ old('fuel_type', $equipment->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                    <option value="gasolina" {{ old('fuel_type', $equipment->fuel_type) == 'gasolina' ? 'selected' : '' }}>Gasolina</option>
                    <option value="eléctrico" {{ old('fuel_type', $equipment->fuel_type) == 'eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                </x-forms.select>

                <x-forms.input
                    label="Capacidad de Combustible (Litros)"
                    name="fuel_capacity"
                    type="number"
                    step="0.01"
                    min="0"
                    placeholder="400"
                    value="{{ old('fuel_capacity', $equipment->fuel_capacity) }}"
                />
            </div>

            <!-- Archivos -->
            @if($equipment->manual_pdf)
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Manual actual:</p>
                    <a class="text-blue-600 hover:text-blue-800 underline"
                       href="{{ route('equipment.manual', $equipment->id) }}"
                       target="_blank">
                        Ver Manual
                    </a>
                </div>
            @endif

            <div class="mb-4">
                <x-forms.input
                    label="Actualizar Manual (PDF)"
                    name="manual_pdf"
                    type="file"
                    accept=".pdf"
                    class="border border-slate-600"
                />
                @if($equipment->manual_pdf)
                    <small class="text-gray-500 mt-1">Deje vacío para mantener el manual actual</small>
                @endif
            </div>

            @if($equipment->equipment_img)
                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Imagen actual:</p>
                    <img src="{{ Storage::url($equipment->equipment_img) }}"
                         alt="Imagen del equipo"
                         class="h-32 w-auto rounded-sm shadow-xs">
                </div>
            @endif

            <div class="mb-4">
                <x-forms.input
                    label="Actualizar Imagen del Equipo"
                    name="equipment_img"
                    type="file"
                    accept="image/*"
                    class="border border-slate-600"
                />
                @if($equipment->equipment_img)
                    <small class="text-gray-500 mt-1">Deje vacío para mantener la imagen actual</small>
                @endif
            </div>

            <x-forms.divider class="bg-yellow-main my-6"/>

            <div class="flex gap-3">
                <x-forms.button type="submit" class="cursor-pointer">
                    Actualizar Equipo
                </x-forms.button>
                <x-link-btn href="{{ route('equipment.show', $equipment) }}">
                    Cancelar
                </x-link-btn>
            </div>
        </x-forms.form>

    </x-panels.main>

</x-app-layout>
