<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategorium;
use App\Models\Proveedor;
use App\Models\Categorium;

use App\Models\Materia_prima;
use Illuminate\Http\Request;

class Materia_primaController extends Controller
{

    public function index(Request $request)
    {
        $materia_prima  = Materia_prima::get();
        return view('admin.materia_prima.index', compact('materia_prima'));
    }

    public function create()
    {
        $new_code = $this->generateNewCode();
        $categorias = Categorium::all();
        $subcategorias = Subcategorium::all();
        $proveedores = Proveedor::all();

        // Pasar valores nulos para categoría y subcategoría
        $categoria_id = null;
        $materia_prima = null;

        return view('admin.materia_prima.create', compact('new_code', 'categorias', 'subcategorias', 'proveedores', 'categoria_id', 'materia_prima'));
    }


    public function getSubcategorias(Request $request)
    {
        $subcategorias = Subcategorium::where('categoria_id', $request->categoria_id)->get();

        if (count($subcategorias) > 0) {
            return response()->json($subcategorias);
        }
    }

    private function generateNewCode()
{
    // Obtener el último código creado
    $last_materia_prima = Materia_prima::orderBy('id', 'desc')->first();

    if ($last_materia_prima) {
        // Extraer el número del último código
        $last_code_number = (int) substr($last_materia_prima->code, 3);
        // Incrementar el número para el nuevo código
        $new_code_number = $last_code_number + 1;
    } else {
        // Si no existe ningún código, empezar desde 1
        $new_code_number = 1;
    }

    // Formatear el nuevo código con ceros a la izquierda
    $new_code = 'MT-' . str_pad($new_code_number, 5, '0', STR_PAD_LEFT);

    // Validar que el nuevo código no exista
    while (Materia_prima::where('codigo', $new_code)->exists()) {
        $new_code_number++;
        $new_code = 'MT-' . str_pad($new_code_number, 5, '0', STR_PAD_LEFT);
    }

    return $new_code;
}


    public function store(Request $request)
    {

        $requestData = $request->all();

        Materia_prima::create($requestData);

        return redirect('admin/materia_prima')->with('correcto', 'Materia_prima added!');
    }


    public function show($id)
    {
        $materia_prima = Materia_prima::findOrFail($id);

        return view('admin.materia_prima.show', compact('materia_prima'));
    }

    public function edit($id)
    {
        $materia_prima = Materia_prima::findOrFail($id);
        $new_code = $this->generateNewCode();
        $categorias = Categorium::all();
        $subcategorias = Subcategorium::all();
        $proveedores = Proveedor::all();

        // Obtener la categoría a partir de la subcategoría de la materia prima
        $categoria_id = null;
        if ($materia_prima->subcategoria_id) {
            $subcategoria = Subcategorium::find($materia_prima->subcategoria_id);
            if ($subcategoria) {
                $categoria_id = $subcategoria->categoria_id;
            }
        }

        return view('admin.materia_prima.edit', compact('new_code', 'categorias', 'subcategorias', 'proveedores', 'materia_prima', 'categoria_id'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $materia_prima = Materia_prima::findOrFail($id);
        $materia_prima->update($requestData);

        return redirect('admin/materia_prima')->with('correcto', 'Materia_prima updated!');
    }

    public function destroy($id)
    {
       Materia_prima::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/materia_prima')->with('correcto', 'Materia_prima deleted!');
    }

       public function reingresar($id)
    {
       Materia_prima::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/materia_prima')->with('correcto', 'Materia_prima deleted!');
    }
}
