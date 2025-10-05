<div id="issueModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="flex justify-between items-center p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Reportar Problema</h3>
                <button class="close-modal text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form class="p-6 space-y-4" id="issueForm">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Componente</label>
                    <input type="text" id="modalComponent" name="componente"
                           class="w-full rounded-md border-gray-300 shadow-xs focus:border-red-500 focus:ring-red-500"
                           readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Problema</label>
                    <select name="tipo_problema"
                            class="w-full rounded-md border-gray-300 shadow-xs focus:border-red-500 focus:ring-red-500">
                        <option>Fuga de aceite</option>
                        <option>Desgaste excesivo</option>
                        <option>Ruido anormal</option>
                        <option>Vibración</option>
                        <option>Mal funcionamiento</option>
                        <option>Daño visible</option>
                        <option>Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Severidad</label>
                    <select name="severidad"
                            class="w-full rounded-md border-gray-300 shadow-xs focus:border-red-500 focus:ring-red-500">
                        <option value="baja">Baja - Operación normal</option>
                        <option value="media">Media - Requiere atención</option>
                        <option value="alta">Alta - Reparación urgente</option>
                        <option value="critica">Crítica - Detener operación</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del Problema</label>
                    <textarea name="descripcion" rows="3"
                              class="w-full rounded-md border-gray-300 shadow-xs focus:border-red-500 focus:ring-red-500"
                              placeholder="Describa detalladamente el problema encontrado..." required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Acción Recomendada</label>
                    <select name="accion_recomendada"
                            class="w-full rounded-md border-gray-300 shadow-xs focus:border-red-500 focus:ring-red-500">
                        <option>Agendar mantenimiento preventivo</option>
                        <option>Reparación inmediata</option>
                        <option>Reemplazo de componente</option>
                        <option>Monitoreo continuo</option>
                        <option>Inspección técnica especializada</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button"
                            class="close-modal px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md font-medium transition-colors">
                        Reportar Problema
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
