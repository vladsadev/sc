<x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    {{'Principal'}}
</x-nav-link>
<x-nav-link href="{{ route('equipment.index') }}" :active="request()->routeIs('equipment.index')">
    Catálogo
</x-nav-link>
<x-nav-link href="{{ route('reportes') }}" :active="request()->routeIs('reportes')">
   Reportes
</x-nav-link>
<x-nav-link href="{{ route('malla') }}" :active="request()->routeIs('malla')">
    Malla
</x-nav-link>
<x-nav-link href="{{ route('manual.index') }}" :active="request()->routeIs('manual.index')">
   Manuales
</x-nav-link>
