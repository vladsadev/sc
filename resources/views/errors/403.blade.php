<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Acceso Denegado
        </h2>
    </x-slot>

    <div class="flex flex-col items-center justify-center min-h-screen text-center">
        <h3 class="text-6xl font-bold text-red-600">403</h3>
        <p class="mt-4 text-xl">Lo sentimos, no tienes permiso para acceder al contenido solicitado o realizar dicha acción .</p>

        <div class="space-y-2 space-x-2 mt-5">
            <x-link-btn href="{{url()->previous()}}"> Volver a la página previa</x-link-btn>
            <x-link-btn href="{{route('dashboard')}}"> Volver a Página Principal</x-link-btn>
        </div>

    </div>

</x-app-layout>
