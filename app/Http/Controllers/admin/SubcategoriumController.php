<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categorium;
use App\Models\Proveedor;

use App\Models\Subcategorium;
use Illuminate\Http\Request;

class SubcategoriumController extends Controller
{

    public function index(Request $request)
    {
        $subcategoria  = Subcategorium::get();
        return view('admin.subcategoria.index', compact('subcategoria'));
    }


    public function create()
    {
        $categorias  = Categorium::get();
        return view('admin.subcategoria.create',compact('categorias'));
    }


    public function store(Request $request)
    {

        $requestData = $request->all();

        Subcategorium::create($requestData);

        return redirect('admin/subcategorias')->with('correcto', 'Subcategorium added!');
    }


    public function show($id)
    {
        $subcategorium = Subcategorium::findOrFail($id);

        return view('admin.subcategoria.show', compact('subcategorium'));
    }

    public function edit($id)
    {
        $subcategorium = Subcategorium::findOrFail($id);
        $categorias  = Categorium::get();

        return view('admin.subcategoria.edit', compact('subcategorium','categorias'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $subcategorium = Subcategorium::findOrFail($id);
        $subcategorium->update($requestData);

        return redirect('admin/subcategorias')->with('correcto', 'Subcategorium updated!');
    }

    public function destroy($id)
    {
       Subcategorium::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/subcategorias')->with('correcto', 'Subcategorium deleted!');
    }

       public function reingresar($id)
    {
       Subcategorium::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/subcategorias')->with('correcto', 'Subcategorium deleted!');
    }
}
