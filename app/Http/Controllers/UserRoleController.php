<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRegister;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserRoleController extends Controller
{
    //
    public function index()
    {

        $users = User::all();

        return view('users.index', ['users' => $users]);

    }

    public function destroy(User $user)
    {
        Gate::authorize('admin-access');

        if (Gate::allows('delete-users', $user)) {
            $user->delete();
            return redirect()
                ->route('user-role.index')
                ->with('success', 'Usuario borrado correctamente.');
        }

        if (Gate::allows('delete-super-admin', $user)) {
            $user->delete();
            return redirect()
                ->route('user-role.index')
                ->with('success', 'Usuario borrado correctamente.');
        }


        return redirect()
            ->route('user-role.index')
            ->with('fail', 'No puedes borrar a un Super Admin o ti mismo');
    }

    public function store(StoreUserRegister $register)
    {
        $validated = $register->validationData();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'occupation' => $validated['occupation'],
            'is_admin' => $validated['role'] === 'admin'
        ]);

        return redirect()->route('user-role.index')
            ->with('success', 'Usuario creado exitosamente.');

    }

    public function create()
    {
        return view('users.create');
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);

    }

    public function update(User $user)
    {
        $validated = request()->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:254', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', 'nullable', 'min:8'],
            'password_confirmation' => ['sometimes', 'nullable', 'same:password'],
            'occupation' => ['sometimes', 'string', 'max:255'],
            'role' => ['sometimes', 'in:user,admin'], // Cambiado de is_admin a role
        ]);

        // Preparar los datos para actualizar
        $dataToUpdate = [];

        // Solo agregar los campos que están presentes en el request validado
        if (array_key_exists('name', $validated) && !empty($validated['name'])) {
            $dataToUpdate['name'] = $validated['name'];
        }

        if (array_key_exists('email', $validated) && !empty($validated['email'])) {
            $dataToUpdate['email'] = $validated['email'];
        }

        if (array_key_exists('occupation', $validated) && !empty($validated['occupation'])) {
            $dataToUpdate['occupation'] = $validated['occupation'];
        }

        // Manejar el password solo si viene y no está vacío
        if (array_key_exists('password', $validated) && !empty($validated['password'])) {
            $dataToUpdate['password'] = bcrypt($validated['password']);
        }

        // Convertir role a is_admin boolean solo si viene
        if (array_key_exists('role', $validated)) {
            $dataToUpdate['is_admin'] = $validated['role'] === 'admin';
        }

        // Actualizar solo los campos que están en $dataToUpdate
        if (!empty($dataToUpdate)) {
            $user->update($dataToUpdate);
        }

        return redirect()
            ->route('user-role.index')
            ->with('success', 'Usuario actualizado correctamente');
    }
}
