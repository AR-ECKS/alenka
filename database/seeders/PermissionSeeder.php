<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // spatie documentation
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'acceso_estadisticas',
            'acceso_alertas',
            'acceso_inicio',

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


            'imprimir_reporte',

            'acceso_proveedores',
            'crear_proveedor',
            'ver_proveedor',
            'editar_proveedor',
            'eliminar_proveedor',
            'restaurar_proveedor',
            // 'acceso_kardex_proveedor',

            'acceso_subcategorias',
            'crear_subcategoria',
            'ver_subcategoria',
            'editar_subcategoria',
            'eliminar_subcategoria',
            'restaurar_subcategoria',

            'acceso_materia_prima',
            'crear_materia_prima',
            'ver_materia_prima',
            'editar_materia_prima',
            'eliminar_materia_prima',
            'restaurar_materia_prima',

            'acceso_compras',
            'crear_compra',
            'ver_compra',
            'eliminar_compra',
            'restaurar_compra',

            'acceso_despachos',
            'crear_despacho',
            'ver_despacho',
            'editar_despacho',
            'eliminar_despacho',
            'restaurar_despacho',

            'acceso_preparaciones',
            'crear_preparacion',
            'ver_preparacion',
            'editar_preparacion',
            'eliminar_preparacion',
            'restaurar_preparacion',

            'acceso_entrega_a_produccion',
            'crear_entrega_a_produccion',
            'ver_entrega_a_produccion',
            'editar_entrega_a_produccion',
            'eliminar_entrega_a_produccion',
            'restaurar_entrega_a_produccion',

            'acceso_produccion',
            'crear_produccion',
            'ver_produccion',
            'editar_produccion',
            'eliminar_produccion',
            'restaurar_produccion',

            'acceso_inventarios',
            'ver_inventario',

            'acceso_kardexs',
            'ver_kardex',

        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
