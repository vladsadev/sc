<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Agregar Manual') }}
            </h2>
            <x-link-btn href="{{ route('manual.index') }}">Volver</x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>
        <x-forms.form method="POST" action="{{ route('manual.store') }}" enctype="multipart/form-data"
                      class="max-w-4xl px-3 md:px-2">

            {{-- Título mejorado con indicador de campos requeridos --}}
            <div class="mb-6">
                <h3 class="text-xl font-bold text-blue-main mb-2">Información del Manual</h3>
                <p class="text-sm text-gray-500">Los campos marcados con <span class="text-red-500">*</span> son obligatorios</p>
            </div>

            {{-- Información básica con select dinámicos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
                {{-- Tipo de Equipo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tipo de Equipo <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="equipment_type"
                        id="equipment_type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                        onchange="updateOptions()"
                    >
                        <option value="" selected>Seleccione un Tipo</option>
                        @foreach($equipments as $index => $equipment)
                            <option value="{{ $index }}" {{ old('equipment_type', '') === (string)$index ? 'selected' : '' }}>
                                {{ $equipment['type'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('equipment_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Modelo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Modelo <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="model"
                        id="model"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                        disabled
                    >
                        <option value="">Primero seleccione un tipo</option>
                    </select>
                    @error('model')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tipo de Manual <span class="text-red-500">*</span>
                    </label>
                    <select
                        name="description"
                        id="description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                        disabled
                    >
                        <option value="">Primero seleccione un tipo</option>
                    </select>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campos adicionales opcionales --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Versión del Manual (Opcional)
                    </label>
                    <input
                        type="text"
                        name="version"
                        value="{{ old('version') }}"
                        placeholder="Ej: v1.0, 2024"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                </div>


            </div>

            {{-- Área mejorada de carga de archivos --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Manual (PDF) <span class="text-red-500">*</span>
                </label>
                <div
                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="manual_pdf"
                                   class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Cargar archivo</span>
                                <input
                                    id="manual_pdf"
                                    name="manual_pdf"
                                    type="file"
                                    accept=".pdf"
                                    class="sr-only"
                                    required
                                    onchange="displayFileName(this)"
                                >
                            </label>
                            <p class="pl-1">o arrastrar y soltar</p>
                        </div>
                        <p class="text-xs text-gray-500">Solo archivos PDF hasta 50MB</p>
                        <p id="file-name" class="text-sm text-gray-900 mt-2 hidden"></p>
                    </div>
                </div>
                @error('manual_pdf')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo de notas --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Notas o Comentarios (Opcional)
                </label>
                <textarea
                    name="notes"
                    rows="3"
                    placeholder="Información adicional relevante sobre este manual..."
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >{{ old('notes') }}</textarea>
            </div>

            {{-- Botones de acción mejorados --}}
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <button
                    type="button"
                    onclick="window.location.href='{{ route('equipment.index') }}'"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    Cancelar
                </button>

                <x-forms.button type="submit" class="cursor-pointer">
                    Guardar Manual
                </x-forms.button>
            </div>
        </x-forms.form>
    </x-panels.main>

    {{-- JavaScript para manejar los selects dinámicos --}}
    <script>
        // Datos de equipos desde PHP
        const equipments = @json($equipments);
        const oldModel = "{{ old('model', '') }}";
        const oldDescription = "{{ old('description', '') }}";
        const oldEquipmentType = "{{ old('equipment_type', '') }}";

        // Inicializar al cargar la página
        document.addEventListener('DOMContentLoaded', function () {
            // Si hay un valor old, actualizar opciones
            if (oldEquipmentType !== '') {
                updateOptions();
            } else {
                // Si no hay valor old, asegurarse de que los selects estén deshabilitados
                const modelSelect = document.getElementById('model');
                const descriptionSelect = document.getElementById('description');
                modelSelect.disabled = true;
                descriptionSelect.disabled = true;

                // Asegurarse de que el primer select muestre "Seleccione un Tipo"
                const typeSelect = document.getElementById('equipment_type');
                typeSelect.value = '';
            }
        });

        function updateOptions() {
            const typeSelect = document.getElementById('equipment_type');
            const modelSelect = document.getElementById('model');
            const descriptionSelect = document.getElementById('description');

            const selectedIndex = typeSelect.value;

            // Limpiar selects
            modelSelect.innerHTML = '<option value="">Seleccione un Modelo</option>';
            descriptionSelect.innerHTML = '<option value="">Seleccione una descripción</option>';

            if (selectedIndex === '' || selectedIndex === null) {
                modelSelect.disabled = true;
                descriptionSelect.disabled = true;
                modelSelect.value = '';
                descriptionSelect.value = '';
                return;
            }

            // Habilitar selects
            modelSelect.disabled = false;
            descriptionSelect.disabled = false;

            // Obtener datos del equipo seleccionado
            const selectedEquipment = equipments[selectedIndex];

            // Poblar modelos
            if (selectedEquipment && selectedEquipment.models) {
                selectedEquipment.models.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    // Mantener selección previa si existe
                    if (model === oldModel) {
                        option.selected = true;
                    }
                    modelSelect.appendChild(option);
                });
            }

            // Poblar descripciones
            if (selectedEquipment && selectedEquipment.description) {
                selectedEquipment.description.forEach(desc => {
                    const option = document.createElement('option');
                    option.value = desc;
                    // Capitalizar primera letra
                    option.textContent = desc.charAt(0).toUpperCase() + desc.slice(1);
                    // Mantener selección previa si existe
                    if (desc === oldDescription) {
                        option.selected = true;
                    }
                    descriptionSelect.appendChild(option);
                });
            }
        }

        // Función para mostrar el nombre del archivo seleccionado
        function displayFileName(input) {
            const fileNameElement = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = (input.files[0].size / 1048576).toFixed(2); // Convertir a MB

                // Validar tamaño
                if (input.files[0].size > 52428800) { // 50MB en bytes
                    alert('El archivo es demasiado grande. El tamaño máximo permitido es 50MB.');
                    input.value = '';
                    fileNameElement.classList.add('hidden');
                    return;
                }

                // Validar tipo
                if (input.files[0].type !== 'application/pdf') {
                    alert('Por favor, seleccione un archivo PDF válido.');
                    input.value = '';
                    fileNameElement.classList.add('hidden');
                    return;
                }

                fileNameElement.textContent = `Archivo seleccionado: ${fileName} (${fileSize} MB)`;
                fileNameElement.classList.remove('hidden');
                fileNameElement.classList.add('text-green-600', 'font-medium');
            } else {
                fileNameElement.classList.add('hidden');
            }
        }

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-blue-400', 'bg-blue-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                const fileInput = document.getElementById('manual_pdf');
                fileInput.files = files;
                displayFileName(fileInput);
            }
        }
    </script>
</x-app-layout>
