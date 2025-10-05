<div class="flex gap-2">
    {{-- Botón Ver --}}
    <a href="{{ route('manual.show', $manual->id) }}"
       target="_blank"
       class="bg-yellow-main hover:bg-blue-main px-3 py-1 text-sm font-semibold rounded text-white transition-colors duration-200">
        Ver Manual
    </a>

    {{-- Botón Eliminar (solo para admins) --}}
    @can('admin-access')
        <form action="{{ route('manual.destroy', $manual->id) }}"
              method="POST"
              class="inline"
              onsubmit="return confirm('¿Está seguro de que desea eliminar este manual?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 px-3 py-1 text-sm font-semibold rounded text-white transition-colors duration-200">
                Eliminar
            </button>
        </form>
    @endcan
</div>
