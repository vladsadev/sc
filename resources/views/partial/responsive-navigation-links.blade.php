<x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
    {{ ('Principal') }}
</x-responsive-nav-link>
<x-responsive-nav-link href="{{ route('equipment.index') }}" :active="request()->routeIs('equipment.index')">
    Catálogo
</x-responsive-nav-link>
<x-responsive-nav-link href="{{ route('reportes') }}" :active="request()->routeIs('reportes')">
    Reportes
</x-responsive-nav-link>
<x-responsive-nav-link href="{{ route('malla') }}" :active="request()->routeIs('malla')">
   Malla
</x-responsive-nav-link>
<x-responsive-nav-link href="{{ route('manual.index') }}" :active="request()->routeIs('manual.index')">
   Manuales
</x-responsive-nav-link>
