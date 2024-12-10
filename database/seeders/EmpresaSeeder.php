<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empresa;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear empresa Grupo CEOQUIM
        Empresa::create([
            'razon_social' => 'Grupo CEOQUIM',
            'nit' => '123456789',
            'nombre_propietario' => 'Alejandro Quisbert',
            'telefono' => '123456789',
            'direccion' => 'Calle 123, Ciudad',
            'descripcion' => 'Empresa dedicada a la producción y distribución de productos químicos.',
            'estado' => 1,
        ]);

        // Crear empresa Indecor
        Empresa::create([
            'razon_social' => 'Indecor',
            'nit' => '987654321',
            'nombre_propietario' => 'Alejandro Quisbert',
            'telefono' => '987654321',
            'direccion' => 'Avenida XYZ, Ciudad',
            'descripcion' => 'Empresa especializada en decoración de interiores y exteriores.',
            'estado' => 1,
        ]);
    }
}
