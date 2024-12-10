<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Categorium;
use Illuminate\Http\Request;

class CategoriumController extends Controller
{

    public function index(Request $request)
    {
        $categoria  = Categorium::get();
        return view('admin.categoria.index', compact('categoria'));
    }


    public function create()
    {
        return view('admin.categoria.create');
    }


    public function store(Request $request)
    {

        $requestData = $request->all();

        Categorium::create($requestData);

        return redirect('admin/categorias')->with('correcto', 'Categorium added!');
    }


    public function show($id)
    {
        $categorium = Categorium::findOrFail($id);

        return view('admin.categoria.show', compact('categorium'));
    }

    public function edit($id)
    {
        $categorium = Categorium::findOrFail($id);

        return view('admin.categoria.edit', compact('categorium'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $categorium = Categorium::findOrFail($id);
        $categorium->update($requestData);

        return redirect('admin/categorias')->with('correcto', 'Categorium updated!');
    }

    public function destroy($id)
    {
       Categorium::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/categorias')->with('correcto', 'Categorium deleted!');
    }

       public function reingresar($id)
    {
       Categorium::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/categorias')->with('correcto', 'Categorium deleted!');
    }
}
