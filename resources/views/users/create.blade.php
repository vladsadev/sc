<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Agregar Nuevo Usuario') }}
            </h2>
            <div class="gap-3">
                <x-link-btn href="{{route('user-role.index')}}">
                    Volver
                </x-link-btn>
            </div>
        </div>
    </x-slot>

    <x-panels.main>
        <x-forms.form method="POST" action="{{route('user-role.store')}}" class="max-w-4xl">
            @csrf

            <!-- Información básica -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <x-forms.input
                    label="Nombre"
                    name="name"
                    placeholder="Juan Ventura"
                    value="{{old('name')}}"/>


                <x-forms.input
                    label="Email"
                    name="email"
                    type="email"
                    placeholder="juanv@jv.com"
                    value="{{old('email')}}"
                    {{--                    required--}}
                />

                <x-forms.input
                    label="Password"
                    name="password"
                    type="password"
                    placeholder="********"
                    {{--                    required--}}
                />

                <x-forms.input
                    label="Confirmación de Password"
                    name="password_confirmation"
                    type="password"
                    placeholder="********"
                    {{--                    required--}}
                />
            </div>
            <x-forms.input
                label="Ocupación"
                name="occupation"
                placeholder="Operador de Maquinaria Pesada"
            />

            <x-forms.divider class="bg-yellow-main my-6"/>

            <x-forms.select label="Nivel Permisos" name="role" required class="mb-8">
                <option value="admin">Administrador</option>
                <option value="user" selected>Usuario</option>
            </x-forms.select>

            <x-forms.button type="submit" class="cursor-pointer lg:mt-8">
                Registrar Usuario
            </x-forms.button>
        </x-forms.form>

    </x-panels.main>
</x-app-layout>


