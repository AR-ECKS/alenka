<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Detalle_produccion;
use Illuminate\Http\Request;

class Detalle_produccionController extends Controller
{

    public function index(Request $request)
    {
        $detalle_produccion  = Detalle_produccion::get();
        return view('admin.detalle_produccion.index', compact('detalle_produccion'));
    }


    public function create()
    {
        return view('admin.detalle_produccion.create');
    }


    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Detalle_produccion::create($requestData);

        return redirect('admin/detalle_produccion')->with('correcto', 'Detalle_produccion added!');
    }


    public function show($id)
    {
        $detalle_produccion = Detalle_produccion::findOrFail($id);

        return view('admin.detalle_produccion.show', compact('detalle_produccion'));
    }

    public function edit($id)
    {
        $detalle_produccion = Detalle_produccion::findOrFail($id);

        return view('admin.detalle_produccion.edit', compact('detalle_produccion'));
    }


    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $detalle_produccion = Detalle_produccion::findOrFail($id);
        $detalle_produccion->update($requestData);

        return redirect('admin/detalle_produccion')->with('correcto', 'Detalle_produccion updated!');
    }

    public function destroy($id)
    {
       Detalle_produccion::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/detalle_produccion')->with('correcto', 'Detalle_produccion deleted!');
    }

       public function reingresar($id)
    {
       Detalle_produccion::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/detalle_produccion')->with('correcto', 'Detalle_produccion deleted!');
    }
}
