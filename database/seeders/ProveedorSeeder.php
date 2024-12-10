<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proveedor;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::create([
            'razon_social' => 'CEOQUIM',
            'pais' => 'Bolivia',
            'direccion' => 'Calle Ejemplo #123',
            'telefono' => '1234567',
            'celular' => '987654321',
            'correo' => 'info@ceoquim.com',
            'pagina_web' => 'https://www.ceoquim.com',
            'nombre_representante' => 'Juan Pérez',
            'telefono_representante' => '5551234',
            'estado' => 'Activo',
        ]);

        // Otros proveedores de ejemplo
        Proveedor::create([
            'razon_social' => 'Comercial Boliviana',
            'pais' => 'Bolivia',
            'direccion' => 'Av. América #456',
            'telefono' => '2345678',
            'celular' => '987654321',
            'correo' => 'ventas@comercialboliviana.com',
            'pagina_web' => 'https://www.comercialboliviana.com',
            'nombre_representante' => 'Ana Gómez',
            'telefono_representante' => '5555678',
            'estado' => 'Activo',
        ]);

        Proveedor::create([
            'razon_social' => 'Fábrica de Productos Químicos',
            'pais' => 'Bolivia',
            'direccion' => 'Calle Principal #789',
            'telefono' => '3456789',
            'celular' => '987654321',
            'correo' => 'info@fabricaproductosquimicos.com',
            'pagina_web' => 'https://www.fabricaproductosquimicos.com',
            'nombre_representante' => 'Pedro Rodríguez',
            'telefono_representante' => '5557890',
            'estado' => 'Activo',
        ]);
    }
}
