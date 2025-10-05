<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Usuarios') }}
            </h2>
            <x-link-btn href="{{route('user-role.create')}}">
                Agregar Usuario
            </x-link-btn>
        </div>
    </x-slot>

    <x-panels.main>
        <div class="px-4 sm:px-6 lg:px-8">
            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="relative min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900
                                sm:pl-0">Nombre
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Ocupación</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Correo
                                    Electrónico
                                </th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                <th scope="col" class="py-3.5 pr-4 pl-3 sm:pr-0">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 bg-gray-200">
                            @foreach($users as $user)
                                <tr>
                                    <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900
                                    sm:pl-1">{{$user->name}}</td>
                                    <x-table-user-item>{{$user->occupation??'-'}}</x-table-user-item>
                                    <x-table-user-item>{{$user->email}}</x-table-user-item>
                                    <x-table-user-item> {{($user->is_super_admin && $user->is_admin)? 'Super Admin' :
                                    ($user->is_admin ?'Administrador':'Usuario' )}}</x-table-user-item>
                                    <x-table-user-item>{{$user->role}}</x-table-user-item>
                                    <td class="py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6 lg:pr-8">
                                        <x-link-btn size="sm" href="{{route('user-role.edit',$user)}}">Editar</x-link-btn>
                                        <form class="inline" action="{{route('user-role.destroy',$user)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-button size="sm" variant="danger">Borrar</x-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </x-panels.main>
</x-app-layout>
