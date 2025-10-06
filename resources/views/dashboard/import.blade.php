<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Importaciones') }}
            </h2>
        </div>
    </x-slot>

    <x-panels.main>

        <x-forms.form method="POST" action="{{ route('import.inspections') }}" enctype="multipart/form-data"
                      class="max-w-4xl px-3 md:px-2">

            <div class="mb-4">
                <x-forms.input
                    label="Archivo de importación"
                    type="file"
                    name="file"
                    accept=".json" required
                class="border-white border-2"/>
            </div>

            <x-forms.divider class="bg-yellow-main my-6"/>

            <x-forms.button type="submit" class="cursor-pointer">
                Importar Inspección
            </x-forms.button>
        </x-forms.form>

    </x-panels.main>


    @if(session('import_results'))
        <div class="alert">
            <p>✅ {{ session('import_results')['success'] }} inspecciones importadas</p>
            @foreach(session('import_results')['failed'] as $error)
                <p>❌ {{ $error }}</p>
            @endforeach
        </div>
    @endif

</x-app-layout>
