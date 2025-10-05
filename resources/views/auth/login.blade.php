<x-guest-layout>

    <div class="flex h-dvh">

        <!-- Left Side - Form -->
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <x-auth.authentication-card-logo class="h-10"/>
                    <h2 class="mt-8 text-2xl/9 font-bold tracking-tight text-gray-900">Ingresa a tu cuenta</h2>
                </div>

                <div class="mt-10">
                    <x-validation-errors class="mb-4"/>

                    @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                    @endsession

                    <form action="{{route('login')}}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <div class="mt-2">
                                <x-auth.label for="email" value="{{ __('Email') }}"/>
                                <x-auth.input id="email" class="block mt-1 w-full" type="email" name="email"
                                              :value="old('email')"
                                              required autofocus autocomplete="username"/>
                            </div>
                        </div>

                        <div>
                            <x-auth.label for="password" value="{{ __('Password') }}"/>
                            <x-auth.input id="password" class="block mt-1 w-full" type="password" name="password" required
                                          autocomplete="current-password"/>

                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember"/>
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                   href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>

                        <div>
                            <x-button class="flex w-full justify-center text-sm/6 font-semibold
                            shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2">
                                {{__('Log in')}}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right side - Image -->
        <div class="hidden lg:block relative flex-1">
            <!-- Background Image -->
            <img src="{{Vite::asset('resources/images/simba1.webp')}}"
                 alt="Equipos mineros" class="absolute inset-0 h-full w-full object-cover"/>

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/50"></div>

            <!-- Gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>

            <!-- Content overlay -->
            <div class="relative flex h-full items-center justify-center p-12">
                <div class="text-center text-white">
                    <div class="mb-8">
                        {{--                    <x-application-logo class="w-16 h-16 mx-auto mb-4"/>--}}
                        <h1 class="text-3xl font-bold drop-shadow-2xl">Sistema <span class="text-yellow-400">SIMBA</span></h1>
                        <p class="text-lg text-gray-200 drop-shadow-xl mt-2">Control de Equipos Mineros</p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 border border-white/20 max-w-md">
                        <h2 class="text-xl font-semibold mb-4 drop-shadow-lg">Gestión Integral</h2>
                        <ul class="text-sm text-gray-200 space-y-2">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Inspecciones de seguridad
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Reportes operacionales
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Control de flota
                            </li>
                        </ul>
                    </div>

                    <div class="text-left mt-1 lg:mt-3">
                        <a href="{{route('register')}}" class="text-yellow-400 text-base underline hover:text-white">Register</a>
                    </div>

                </div>

            </div>


        </div>
    </div>


</x-guest-layout>
