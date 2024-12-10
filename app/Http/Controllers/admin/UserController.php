<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserEditRequest;
use App\Models\User;
use App\Models\Caja;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::get();
        $roles = Role::all()->pluck('name', 'id');

        // Carga los roles de cada usuario
        foreach ($users as $user) {
            $user->load('roles');
            $user->userRoles = $user->roles->pluck('id')->toArray();
        }

        return view('users.index', compact('users', 'roles'));
    }

    public function show(User $user)
    {

        $user->load('roles');
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            // Obtener datos del formulario
            $requestData = $request->only('name', 'username', 'email', 'maquina');

            // Verificar si el checkbox 'operador' está marcado
            if ($request->has('operador')) {
                $requestData['tipo'] = 2; // Asignar 2 si está marcado
            } else {
                $requestData['tipo'] = 1; // Asignar un valor por defecto o diferente si no está marcado
            }

            // Manejar el archivo de imagen si está presente en la solicitud
            if ($request->hasFile('imagen')) {
                $requestData['imagen'] = $request->file('imagen')->store('uploads', 'public');
            }

            // Crear el usuario en la base de datos, incluyendo la contraseña encriptada
            $user = User::create($requestData + [
                'password' => bcrypt($request->input('password')),
            ]);

            // Obtener los roles seleccionados en el formulario
            $roles = $request->input('roles', []);

            // Asignar los roles al usuario utilizando assignRole para un solo rol o syncRoles para múltiples roles
            foreach ($roles as $role) {
                $user->assignRole($role);
            }

            // Opción para asignar múltiples roles utilizando syncRoles
            // $user->syncRoles($roles);

            // Redirigir a la página de detalles del usuario con un mensaje de éxito
            return redirect()->route('users.index')->with('correcto', 'correcto');
        } catch (\Exception $e) {
            // Manejar la excepción
            return redirect()->route('users.index')->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }



    public function edit(User $user)
    {
        // $cajas = Caja::All();
        // $sucursals = Sucursal::All();
        $cajaActual = $user->caja;
        $sucursalActual = $user->sucursal;
        // abort_if(Gate::denies('user_edit'), 403);
        $roles = Role::all()->pluck('name', 'id');
        $user->load('roles');
        $userRoles = $user->roles->pluck('id')->toArray();

        return view('users.edit', compact('user', 'roles', 'cajaActual', 'sucursalActual', 'userRoles'));
    }

    public function update(UserEditRequest $request, User $user)
    {
        try {
            $data = $request->only('name', 'username', 'email');

            $password = $request->input('password');
            if ($password) {
                $data['password'] = bcrypt($password);
            }

            if ($request->hasFile('imagen')) {
                $data['imagen'] = $request->file('imagen')->store('uploads', 'public');
            }
            $rolesIds = $request->input('roles', []);

            $rolesToSync = [];

            foreach ($rolesIds as $roleId) {
                $role = Role::find($roleId);
                if ($role) {
                    $rolesToSync[] = $role->name;
                }
            }

            $user->syncRoles($rolesToSync);

            $user->update($data);

            return redirect()->route('users.index')->with('correcto', 'correcto');
        } catch (\Exception $e) {
            // Manejar la excepción aquí
            return redirect()->route('users.index')->with('error', 'error');
        }
    }


    public function destroy(User $user)
    {
        User::where('id', $user->id)->update(['estado' => '0']);

        return redirect()->route('users.index')->with('correcto','correcto');
    }

    public function reingresar($id)
    {

        User::where('id', $id)->update(['estado' => '1']);

        return redirect()->route('users.index')->with('correcto','correcto');
    }
}
