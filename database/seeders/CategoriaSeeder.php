<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorium;
use App\Models\Subcategorium;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categorium::create([
            'nombre' => 'PARA PREPARACIÓN',
            'descripcion' => 'Categoría para productos destinados a la preparación.',
            'estado' => 'Activo',
        ]);

        Categorium::create([
            'nombre' => 'PARA PRODUCCIÓN',
            'descripcion' => 'Categoría para productos destinados a la producción.',
            'estado' => 'Activo',
        ]);
        // Subcategorías para la categoría 'PARA PREPARACIÓN'
        Subcategorium::create([
            'categoria_id' => 1,
            'nombre' => 'Productos Químicos',
        ]);

        Subcategorium::create([
            'categoria_id' => 1,
            'nombre' => 'Edulcorante Compuesto',
        ]);

        Subcategorium::create([
            'categoria_id' => 1,
            'nombre' => 'Aditivos',
        ]);

        Subcategorium::create([
            'categoria_id' => 1,
            'nombre' => 'Esencias',
        ]);

        // Subcategoría para la categoría 'PARA PRODUCCIÓN'
        Subcategorium::create([
            'categoria_id' => 2,
            'nombre' => 'Empaque',
        ]);
    }
}
