{{-- resources/views/components/dashboard-alerts.blade.php --}}

@if(count($criticalAlerts) > 0 || count($warningAlerts) > 0 || count($infoAlerts) > 0)
    <div class="mb-8">
        <x-description-heading>Alertas y Notificaciones</x-description-heading>

        <div class="space-y-4">
            {{-- Alertas Críticas --}}
            @foreach($criticalAlerts as $alert)
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-xs">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <i class="{{ $alert['icon'] }} h-5 w-5 text-red-500"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-red-800">
                                {{ $alert['title'] }}
                            </h3>
                            <div class="mt-1 text-sm text-red-700">
                                <p>{{ $alert['message'] }}</p>
                            </div>
                            @if(isset($alert['action']))
                                <div class="mt-2">
                                    <a href="{{ $alert['action'] }}"
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-red-800 bg-red-100 hover:bg-red-200 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        {{ $alert['action_text'] }}
                                        <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="shrink-0 ml-4">
                            <button type="button"
                                    class="inline-flex text-red-400 hover:text-red-600 focus:outline-hidden focus:text-red-600"
                                    onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                                <span class="sr-only">Cerrar</span>
                                <i class="fas fa-times h-4 w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Alertas de Advertencia --}}
            @foreach($warningAlerts as $alert)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-xs">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <i class="{{ $alert['icon'] }} h-5 w-5 text-yellow-500"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-yellow-800">
                                {{ $alert['title'] }}
                            </h3>
                            <div class="mt-1 text-sm text-yellow-700">
                                <p>{{ $alert['message'] }}</p>
                            </div>
                            @if(isset($alert['action']))
                                <div class="mt-2">
                                    <a href="{{ $alert['action'] }}"
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-yellow-800 bg-yellow-100 hover:bg-yellow-200 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                        {{ $alert['action_text'] }}
                                        <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="shrink-0 ml-4">
                            <button type="button"
                                    class="inline-flex text-yellow-400 hover:text-yellow-600 focus:outline-hidden focus:text-yellow-600"
                                    onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                                <span class="sr-only">Cerrar</span>
                                <i class="fas fa-times h-4 w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Alertas Informativas --}}
            @foreach($infoAlerts as $alert)
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg shadow-xs">
                    <div class="flex items-start">
                        <div class="shrink-0">
                            <i class="{{ $alert['icon'] }} h-5 w-5 text-blue-500"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-medium text-blue-800">
                                {{ $alert['title'] }}
                            </h3>
                            <div class="mt-1 text-sm text-blue-700">
                                <p>{{ $alert['message'] }}</p>
                            </div>
                            @if(isset($alert['action']))
                                <div class="mt-2">
                                    <a href="{{ $alert['action'] }}"
                                       class="inline-flex items-center px-3 py-2 border border-transparent text-xs font-medium rounded-md text-blue-800 bg-blue-100 hover:bg-blue-200 focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        {{ $alert['action_text'] }}
                                        <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="shrink-0 ml-4">
                            <button type="button"
                                    class="inline-flex text-blue-400 hover:text-blue-600 focus:outline-hidden focus:text-blue-600"
                                    onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                                <span class="sr-only">Cerrar</span>
                                <i class="fas fa-times h-4 w-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
