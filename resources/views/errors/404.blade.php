<x-guest-layout>
    <main class="relative isolate h-full">
        <img src="{{Vite::asset("resources/images/404.webp")}}" alt="" class="absolute inset-0 -z-10 size-full object-cover
        object-top brightness-50"/>
        <div class="mx-auto max-w-7xl px-6 py-32 text-center sm:py-40 lg:px-8">
            <p class="text-base/8 font-semibold text-white">404</p>`
            <h1 class="mt-4 text-5xl font-semibold tracking-tight text-balance text-white sm:text-7xl">Página No Encontrada</h1>
            <p class="mt-6 text-lg font-medium text-pretty text-white/70 sm:text-xl/8">
                La página que estás buscando no existe.
            </p>
            <div class="mt-10 flex justify-center">
                <a href="{{route('dashboard')}}" class="text-sm/7 font-semibold text-white hover:text-white/90"><span
                        aria-hidden="true">&larr;
                    </span> Volver al Panel Principal</a>
            </div>
        </div>
    </main>
</x-guest-layout>
