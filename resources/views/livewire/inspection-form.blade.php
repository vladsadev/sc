<div class="shadow-xl rounded-lg overflow-hidden bg-white">
    {{-- Barra de progreso general --}}
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700">Progreso de inspección</span>
            <span class="text-sm text-gray-600">
                {{ count($checkedItems) }}/{{ $this->totalItems }} elementos revisados
                @if($this->issuesCount > 0)
                    <span class="text-red-600 ml-2">({{ $this->issuesCount }} problemas)</span>
                @endif
            </span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="h-3 rounded-full transition-all duration-500
                {{ $this->progress >= 100 ? 'bg-green-600' : ($this->progress >= 50 ? 'bg-blue-600' : 'bg-yellow-500') }}"
                 style="width: {{ $this->progress }}%">
            </div>
        </div>
    </div>

    <form wire:submit.prevent="submit" class="p-6">
        {{-- Iterar sobre cada sección --}}
        @foreach($inspectionConfig['sections'] as $sectionKey => $section)
            <div class="mb-8">
                {{-- Título de sección con indicador de progreso --}}
                <div class="bg-blue-main text-white px-4 py-3 rounded-t-lg flex items-center justify-between">
                    <h3 class="font-semibold text-lg">{{ $section['title'] }}</h3>
                    <div class="flex items-center space-x-3">
                        @if($this->isSectionComplete($sectionKey))
                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                ✓ Completo
                            </span>
                        @else
                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $sectionProgress[$sectionKey]['checked'] }}/{{ $sectionProgress[$sectionKey]['total'] }}
                            </span>
                        @endif

                        @if($sectionProgress[$sectionKey]['issues'] > 0)
                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                ⚠ {{ $sectionProgress[$sectionKey]['issues'] }} problema(s)
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Items de la sección --}}
                <div class="border-l-2 border-r-2 border-b-2 border-gray-200 rounded-b-lg">
                    @foreach($section['items'] as $itemKey => $itemLabel)
                        <div class="inspection-item flex items-center justify-between py-3 px-4
                            {{ !$loop->last ? 'border-b border-gray-100' : '' }}
                            transition-all duration-300 hover:bg-gray-50
                            {{ in_array($itemKey, $checkedItems) ? 'bg-green-50' : '' }}
                            {{ isset($reportedIssues[$itemKey]) ? 'bg-red-50' : '' }}">

                            <div class="flex items-center space-x-3 flex-1">
                                {{-- Checkbox --}}
                                <input
                                    type="checkbox"
                                    id="item_{{ $itemKey }}"
                                    wire:click="toggleItem('{{ $itemKey }}')"
                                    {{ in_array($itemKey, $checkedItems) ? 'checked' : '' }}
                                    {{ isset($reportedIssues[$itemKey]) ? 'disabled' : '' }}
                                    class="h-5 w-5 text-green-600 rounded focus:ring-green-500 border-gray-300
                                           {{ isset($reportedIssues[$itemKey]) ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}">

                                {{-- Descripción del item --}}
                                <label for="item_{{ $itemKey }}"
                                       class="text-gray-700 cursor-pointer select-none flex-1
                                              {{ in_array($itemKey, $checkedItems) ? 'line-through text-green-600' : '' }}
                                              {{ isset($reportedIssues[$itemKey]) ? 'text-red-600' : '' }}">
                                    {{ $itemLabel }}
                                </label>
                            </div>

                            <div class="flex items-center space-x-2">
                                {{-- Indicador de estado --}}
                                @if(in_array($itemKey, $checkedItems))
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ OK
                                    </span>
                                @elseif(isset($reportedIssues[$itemKey]))
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ⚠ Problema
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        ⚠ Pendiente
                                    </span>
                                @endif

                                {{-- Botón para reportar problema --}}
                                <button type="button"
                                        wire:click="openIssueModal('{{ $itemKey }}')"
                                        class="text-red-500 hover:text-red-700 transition-colors p-1.5 rounded-lg hover:bg-red-50"
                                        title="{{ isset($reportedIssues[$itemKey]) ? 'Editar problema' : 'Reportar problema' }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                </button>

                                {{-- Si hay problema reportado, botón para eliminarlo --}}
                                @if(isset($reportedIssues[$itemKey]))
                                    <button type="button"
                                            wire:click="removeIssue('{{ $itemKey }}')"
                                            class="text-gray-400 hover:text-gray-600 transition-colors p-1.5 rounded-lg hover:bg-gray-50"
                                            title="Eliminar problema">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Sección de observaciones,horometros y EPP --}}
        <div class="mt-8 space-y-6 border-t pt-6">
            {{-- Campo de horómetros y de observaciones --}}
            <div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-3">
                    <x-forms.input
                        label="Horas del Motor"
                        id="engineHours"
                        name="engineHours"
                        type="number"
                        step="0.1"
                        placeholder="Ej. 123.6"
                        wire:model="engineHours"
                    />

                    <x-forms.input
                        label="Horas de Percusión"
                        id="percussionHours"
                        name="percussionHours"
                        type="number"
                        step="0.1"
                        placeholder="254.3"
                        wire:model="percussionHours"
                    />

                    <x-forms.input
                        label="Horas de Posicionamiento"
                        id="positionHours"
                        name="positionHours"
                        type="number"
                        step="0.1"
                        placeholder="147.2"
                        wire:model="positionHours"
                    />
                </div>

                <label for="observations" class="block text-base font-medium text-gray-700 mb-2">
                    Observaciones Generales
                </label>
                <textarea
                    id="observations"
                    wire:model="observations"
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ingrese observaciones adicionales sobre la inspección si considera necesario..."></textarea>
            </div>

            {{-- Checkbox de EPP --}}
            <div class="flex items-center space-x-3 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <input
                    type="checkbox"
                    id="epp"
                    wire:model="epp"
                    class="h-5 w-5 text-blue-600 rounded-sm focus:ring-blue-500 border-gray-300">
                <label for="epp" class="text-gray-700 font-medium cursor-pointer select-none">
                    Confirmo que cuento con el EPP completo y en buen estado
                </label>
            </div>
        </div>


        {{-- Mensajes de error --}}
        @if($errors->any())
            <div class="mt-4 bg-red-50 border-l-4 border-red-400 p-4">
                <div class="flex">
                    <div class="shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            Se encontraron los siguientes errores:
                        </h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Botones de acción --}}
        <div class="mt-8 flex items-center justify-between">
            <a href="{{ route('equipment.show', $equipment) }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Cancelar
            </a>

            <button type="submit"
                    class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-xs text-white bg-blue-600 hover:bg-blue-700 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"></path>
                    </svg>
                    Guardar Inspección
                </span>
                <span wire:loading>
                    <svg class="inline animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"
                                fill="none"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Guardando...
                </span>
            </button>
        </div>
    </form>

    {{-- Modal para Reportar Problemas --}}
    @if($showIssueModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-gray-900">Reportar Problema</h3>
                        <button wire:click="closeIssueModal"
                                type="button"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    {{-- Componente afectado --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Componente</label>
                        <div class="text-gray-900 font-semibold">
                            @foreach($inspectionConfig['sections'] as $section)
                                @if(isset($section['items'][$currentIssueComponent]))
                                    {{ $section['items'][$currentIssueComponent] }}
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Tipo de problema --}}
                    <div>
                        <label for="issue_type" class="block text-sm font-medium text-gray-700 mb-1">
                            Tipo de problema(estado del estado componente)<span class="text-red-500">*</span>
                        </label>
                        <select id="issue_type"
                                wire:model="currentIssue.tipo_problema"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                       @error('currentIssue.tipo_problema') border-red-500 @enderror">
                            <option value="">Seleccione...</option>
                            <option value="bueno">Bueno</option>
                            <option value="malo">Malo</option>
                            <option value="no_aplica">No Aplica</option>
                        </select>
                        @error('currentIssue.tipo_problema')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            Descripción del Problema <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description"
                                  wire:model="currentIssue.descripcion"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                                         @error('currentIssue.descripcion') border-red-500 @enderror"
                                  placeholder="Describa el problema encontrado..."></textarea>
                        @error('currentIssue.descripcion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Botones del modal --}}
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button wire:click="closeIssueModal"
                            type="button"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button wire:click="saveIssue"
                            type="button"
                            class="px-4 py-2 border border-transparent rounded-lg text-white bg-red-600 hover:bg-red-700">
                        Guardar Problema
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
