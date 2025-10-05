<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Agregar Equipo') }}
            </h2>
            <x-link-btn href="{{ route('equipment.index') }}">Volver</x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>
        <x-forms.form method="POST" action="{{ route('equipment.store') }}" enctype="multipart/form-data"
                      class="max-w-4xl px-3 md:px-2">

            <h3 class="text-xl font-bold text-blue-main mb-4">Campos Obligatorios</h3>

            <!-- Información básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <x-forms.input
                    label="Código"
                    name="code"
                    placeholder="EXC-001"
                    required
                />

                <x-forms.input
                    label="Marca"
                    name="brand"
                    placeholder="Caterpillar"
                    value="{{old('brand')}}"
                    required
                />

                <x-forms.input
                    label="Modelo"
                    name="model"
                    placeholder="S7D"
                    value="{{old('model')}}"
                    required
                />

                <x-forms.input
                    label="Año"
                    name="year"
                    type="number"
                    min="1990"
                    max="{{ date('Y') + 1 }}"
                    value="{{old('year')}}"
                    placeholder="2024"
                    required
                />
            </div>

            <div class="mb-4">
                <x-forms.select label="Estado" name="status" required>
                    <option value="operativa" {{ old('status') == 'operativa' ? 'selected' : '' }}>Operativa</option>
                    <option value="mantenimiento" {{ old('status') == 'mantenimiento' ? 'selected' : '' }}>En Mantenimiento
                    </option>
                    <option value="inactiva" {{ old('status') == 'inactiva' ? 'selected' : '' }}>Inactiva</option>
                </x-forms.select>
            </div>


            <!-- Ubicación -->
            <div class="mb-4">
                <x-forms.select label="Ubicación" name="location" required>
                    <option value="">Seleccione una ubicación</option>
                    <option value="Interior mina" {{old('location')=='Interior mina'? 'selected':''}}>Interior Mina</option>
                    <option value="Exterior mina" {{old('location')=='Exterior mina'? 'selected':''}} >Exterior Mina</option>
                    <option value="Área de Mantenimiento" {{old('location')=='Área de Mantenimiento'? 'selected':''}} >Área de
                        Mantenimiento
                    </option>
                    <option value="Apartada de la Empresa" {{old('location')=='Apartada de la Empresa'? 'selected':''}} >Apartada
                        de la
                        Empresa
                    </option>
                </x-forms.select>
            </div>

            <!-- Tipo de Equipo -->
            <div class="mb-4">
                <x-forms.select label="Tipo de Equipo" name="equipment_type_id" required>
                    <option value="">Seleccione un tipo</option>
                    @foreach($eTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </x-forms.select>
            </div>

            <!-- Especificaciones Técnicas (Opcionales) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-forms.select label="Tipo de Combustible" name="fuel_type">
                    <option value="">Seleccione (opcional)</option>
                    <option value="diesel">Diesel</option>
                    <option value="gasolina">Gasolina</option>
                    <option value="eléctrico">Eléctrico</option>
                </x-forms.select>

                <x-forms.input
                    label="Capacidad de Combustible (Litros)"
                    name="fuel_capacity"
                    type="number"
                    step="0.01"
                    min="0"
                    placeholder="400"
                />
            </div>

            <div class="mb-4">
                <x-forms.input
                    label="Imagen del Equipo"
                    name="equipment_img"
                    type="file"
                    accept="image/*"
                    class="border border-slate-600"
                />
            </div>

            <x-forms.divider class="bg-yellow-main my-6"/>

            <x-forms.button type="submit" class="cursor-pointer">
                Guardar Equipo
            </x-forms.button>
        </x-forms.form>
    </x-panels.main>
</x-app-layout>
