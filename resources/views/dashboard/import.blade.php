<x-app-layout>

    <!-- dashboard/import.blade.php -->
    <form action="{{ route('import.inspections') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept=".json" required>
        <button type="submit">Importar Inspecciones</button>
    </form>

    @if(session('import_results'))
        <div class="alert">
            <p>✅ {{ session('import_results')['success'] }} inspecciones importadas</p>
            @foreach(session('import_results')['failed'] as $error)
                <p>❌ {{ $error }}</p>
            @endforeach
        </div>
    @endif

</x-app-layout>
