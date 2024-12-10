<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User; // Agrega esta línea para importar la clase User
use App\Http\Controllers\Controller;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // abort_if(Gate::denies('acceso_roles'), 403);


        $roles = Role::get();
        $permissions = [
            'Inicio' => [
                'acceso_estadisticas',
                'acceso_alertas',
                'acceso_inicio',
            ],

            'Administracion' => [

              'acceso_roles',
            'crear_rol',
            'ver_rol',
            'editar_rol',
            'eliminar_rol',
            'restaurar_rol',

            'acceso_usuarios',
            'crear_usuario',
            'ver_usuario',
            'editar_usuario',
            'eliminar_usuario',
            'restaurar_usuario',
            'imprimir_reportes',

                // ... otros permisos relacionados con ventas
            ],

            'Subcategorias' => [
                'acceso_subcategorias',
                'crear_subcategoria',
                'ver_subcategoria',
                'editar_subcategoria',
                'eliminar_subcategoria',
                'restaurar_subcategoria',

                // ... otros permisos relacionados con "Mi Caja"
            ],



            'Proveedores' => [
                'acceso_proveedores',
                'crear_proveedor',
                'ver_proveedor',
                'editar_proveedor',
                'eliminar_proveedor',
                'restaurar_proveedor',
                // ... otros permisos relacionados con proveedores
            ],

            'Materia Prima' => [
                'acceso_materia_prima',
                'crear_materia_prima',
                'ver_materia_prima',
                'editar_materia_prima',
                'eliminar_materia_prima',
                'restaurar_materia_prima',

            ],
            'Compras' => [
                'acceso_compras',
                'crear_compra',
                'ver_compra',
                'eliminar_compra',
                'restaurar_compra',
                // ... otros permisos relacionados con compras
            ],
            'Despachos' => [
                'acceso_despachos',
                'crear_despacho',
                'ver_despacho',
                'editar_despacho',
                'eliminar_despacho',
                'restaurar_despacho',
            ],

            'Preparaciónes' => [
                'acceso_preparaciones',
                'crear_preparacion',
                'ver_preparacion',
                'editar_preparacion',
                'eliminar_preparacion',
                'restaurar_preparacion',
                // ... otros permisos relacionados con atributos
            ],
            'Entregas a producción' => [
                'acceso_entrega_a_produccion',
                'crear_entrega_a_produccion',
                'ver_entrega_a_produccion',
                'editar_entrega_a_produccion',
                'eliminar_entrega_a_produccion',
                'restaurar_entrega_a_produccion',
            ],

            'Produccion' => [
                'acceso_produccion',
                'crear_produccion',
                'ver_produccion',
                'editar_produccion',
                'eliminar_produccion',
                'restaurar_produccion',
            ],

            'Inventario' => [
                'acceso_inventarios',
                'ver_precio_compra',
                'ver_inventario',
                // ... otros permisos relacionados con inventario
            ],
            'Kardex' => [
                'acceso_kardexs',
                'ver_kardex',
                // ... otros permisos relacionados con el kardex de salidas
            ],


        ];

        return view('roles.index', compact('roles', 'permissions'))->with('message3', 'Rol desactivado exitosamente.');
    }

    public function store(Request $request)
    {
        try {
            // Obtener los permisos proporcionados en la solicitud
            $permissions = $request->input('permissions', []);

            // Verificar si los permisos existen en la base de datos antes de continuar
            foreach ($permissions as $permissionName) {
                if (!Permission::where('name', $permissionName)->exists()) {
                    // Si un permiso no existe, lanzar una excepción y cancelar la creación del rol
                    throw new \Exception("El permiso '$permissionName' no existe en la base de datos.");
                }
            }

            // Crear un nuevo rol con los datos proporcionados en la solicitud
            $role = Role::create($request->only('name'));

            // Asignar permisos al rol utilizando syncPermissions
            $role->syncPermissions($permissions);

            // Redirigir a la vista de índice de roles con un mensaje de éxito
            return redirect()->route('roles.index')->with('correcto', 'correcto');
        } catch (\Exception $e) {
            // Manejar la excepción aquí
            return redirect()->route('roles.index')->with('error', 'error');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // abort_if(Gate::denies('role_show'), 403);

        $role->load('permissions');
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // Obtén todas las categorías de permisos
        $permissions = [
            'Inicio' => [
                'acceso_estadisticas',
                'acceso_alertas',
                'acceso_inicio',
            ],

            'Administracion' => [

              'acceso_roles',
            'crear_rol',
            'ver_rol',
            'editar_rol',
            'eliminar_rol',
            'restaurar_rol',

            'acceso_usuarios',
            'crear_usuario',
            'ver_usuario',
            'editar_usuario',
            'eliminar_usuario',
            'restaurar_usuario',
            'imprimir_reportes',

                // ... otros permisos relacionados con ventas
            ],

            'Subcategorias' => [
                'acceso_subcategorias',
                'crear_subcategoria',
                'ver_subcategoria',
                'editar_subcategoria',
                'eliminar_subcategoria',
                'restaurar_subcategoria',

                // ... otros permisos relacionados con "Mi Caja"
            ],



            'Proveedores' => [
                'acceso_proveedores',
                'crear_proveedor',
                'ver_proveedor',
                'editar_proveedor',
                'eliminar_proveedor',
                'restaurar_proveedor',
                // ... otros permisos relacionados con proveedores
            ],

            'Materia Prima' => [
                'acceso_materia_prima',
                'crear_materia_prima',
                'ver_materia_prima',
                'editar_materia_prima',
                'eliminar_materia_prima',
                'restaurar_materia_prima',

            ],
            'Compras' => [
                'acceso_compras',
                'crear_compra',
                'ver_compra',
                'eliminar_compra',
                'restaurar_compra',
                // ... otros permisos relacionados con compras
            ],
            'Despachos' => [
                'acceso_despachos',
                'crear_despacho',
                'ver_despacho',
                'editar_despacho',
                'eliminar_despacho',
                'restaurar_despacho',
            ],

            'Preparaciónes' => [
                'acceso_preparaciones',
                'crear_preparacion',
                'ver_preparacion',
                'editar_preparacion',
                'eliminar_preparacion',
                'restaurar_preparacion',
                // ... otros permisos relacionados con atributos
            ],
            'Entregas a producción' => [
                'acceso_entrega_a_produccion',
                'crear_entrega_a_produccion',
                'ver_entrega_a_produccion',
                'editar_entrega_a_produccion',
                'eliminar_entrega_a_produccion',
                'restaurar_entrega_a_produccion',
            ],

            'Produccion' => [
                'acceso_produccion',
                'crear_produccion',
                'ver_produccion',
                'editar_produccion',
                'eliminar_produccion',
                'restaurar_produccion',
            ],

            'Inventario' => [
                'acceso_inventarios',
                'ver_precio_compra',
                'ver_inventario',
                // ... otros permisos relacionados con inventario
            ],
            'Kardex' => [
                'acceso_kardexs',
                'ver_kardex',
                // ... otros permisos relacionados con el kardex de salidas
            ],



        ];

        // Carga los permisos asociados al rol
        $role->load('permissions');

        return view('roles.edit', compact('role', 'permissions'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->only('name'));

        // $role->permissions()->sync($request->input('permissions', []));
        $role->syncPermissions($request->input('permissions', []));

        return redirect()->route('roles.index')->with('message4', 'Rol desactivado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        // Verifica si algún usuario tiene asignado este rol
        $usersWithRole = User::whereHas('roles', function ($query) use ($role) {
            $query->where('name', $role->name);
        })->count();

        if ($usersWithRole > 0) {
            return redirect()->route('roles.index')->with('message1', 'No puedes desactivar un rol que tiene usuarios asignados.');
        }

        // Cambiar el estado a 0 en lugar de eliminar
        $role->update(['estado' => 0]);

        return redirect()->route('roles.index')->with('message2', 'Rol desactivado exitosamente.');
    }

    public function reingresar($id)
    {
        // Buscar el rol por ID
        $role = Role::findOrFail($id);

        // Verificar si el rol ya está activo antes de actualizar el estado
        if ($role->estado == 1) {
            return redirect()->route('roles.index')->with('warning', 'El rol ya está activo.');
        }

        // Actualizar el estado a 1 para "activar" el rol
        $role->update(['estado' => 1]);

        return redirect()->route('roles.index')->with('success', 'Rol reingresado exitosamente.');
    }
}
