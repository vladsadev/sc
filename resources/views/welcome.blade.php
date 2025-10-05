<x-guest-layout>


    <main>
        <!-- Hero section -->
        <div class="relative isolate overflow-hidden bg-gray-900 pt-6 lg:pt-16 pb-8 sm:pb-12 min-h-screen">
            <!-- Background Image -->
            <img src="{{Vite::asset('resources/images/simba1.webp')}}"
                 alt="Equipo minero en operación" class="absolute inset-0 -z-20 size-full object-cover"/>

            <!-- Dark Overlay for better text contrast -->
            <div class="absolute inset-0 -z-10 bg-black/60"></div>

            <!-- Gradient overlay for additional depth -->
            <div class="absolute inset-0 -z-10 bg-linear-to-t from-black/80 via-black/40 to-black/20"></div>

            <div aria-hidden="true"
                 class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
                <div
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-10 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
            </div>

            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl py-12 sm:py-14 lg:pt-20 lg:pb-12  xl:pt-32 2xl:pt-40">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-balance text-white sm:text-6xl drop-shadow-2xl">
                            Sistema de Control
                            <span class="text-yellow-400 drop-shadow-2xl">SIMBA</span>
                        </h1>
                        <p class="mt-6 lg:mt-8 text-base font-medium text-pretty text-gray-200 sm:text-lg/7 drop-shadow-xl
                        max-w-2xl mx-auto">
                            Control y monitoreo del estado de equipos pesados para operaciones mineras.
                            Gestiona inspecciones de seguridad y reportes operacionales de manera eficiente.
                        </p>
                        <div class="mt-8 lg:mt-10 flex items-center justify-center gap-x-6">
                            <x-link-btn href="{{route('login')}}">{{__("Log In")}}</x-link-btn>

                            <a href="https://www.epiroc.com/" target="_blank" class="text-sm font-semibold text-white
                            hover:text-gray-200
                            transition-colors duration-200 drop-shadow-lg">
                                Ver Equipos <span aria-hidden="true">↓</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Equipos Section -->
                <div id="equipos" class="mx-auto max-w-7xl pb-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white drop-shadow-2xl mb-2">Equipos Monitoreados</h2>
                        <p class="text-gray-200 drop-shadow-xl">Controla el estado operacional de tu flota de equipos pesados</p>
                    </div>

                    <!-- Equipment Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                        <!-- Excavadoras -->
                        <div
                            class="bg-white/10 backdrop-blur-xs rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto mb-3 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19 7h-3V6a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1H7a1 1 0 0 0-1 1v11a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V8a1 1 0 0 0-1-1zM11 6h2v1h-2V6zm6 13a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1V9h8v10z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white drop-shadow-lg mb-1">Excavadoras</h3>
                                <p class="text-gray-200 drop-shadow-lg text-sm">Control de palas y sistemas hidráulicos</p>
                            </div>
                        </div>

                        <!-- Camiones -->
                        <div
                            class="bg-white/10 backdrop-blur-xs rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto mb-3 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20 8h-3V6c0-1.1-.9-2-2-2H3c-1.1 0-2 .9-2 2v6c0 1.1.9 2 2 2v2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3v-2c1.1 0 2-.9 2-2v-3c0-1.1-.9-2-2-2zM6 17.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm12 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white drop-shadow-lg mb-1">Camiones</h3>
                                <p class="text-gray-200 drop-shadow-lg text-sm">Monitoreo de sistemas de transporte</p>
                            </div>
                        </div>

                        <!-- Perforadoras -->
                        <div
                            class="bg-white/10 backdrop-blur-xs rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all duration-300">
                            <div class="text-center">
                                <div class="w-12 h-12 mx-auto mb-3 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M21 3H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H3V5h18v14zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white drop-shadow-lg mb-1">Perforadoras</h3>
                                <p class="text-gray-200 drop-shadow-lg text-sm">Control de equipos de perforación</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div aria-hidden="true"
                 class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
                <div
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"
                    class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-10 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
            </div>
        </div>
    </main>
</x-guest-layout>
