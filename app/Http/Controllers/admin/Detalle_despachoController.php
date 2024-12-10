<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Detalle_despacho;
use Illuminate\Http\Request;

class Detalle_despachoController extends Controller
{

    public function index(Request $request)
    {
        $detalle_despacho  = Detalle_despacho::get();
        return view('admin.detalle_despacho.index', compact('detalle_despacho'));
    }


    public function create()
    {
        return view('admin.detalle_despacho.create');
    }


    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Detalle_despacho::create($requestData);

        return redirect('admin/detalle_despacho')->with('correcto', 'Detalle_despacho added!');
    }


    public function show($id)
    {
        $detalle_despacho = Detalle_despacho::findOrFail($id);

        return view('admin.detalle_despacho.show', compact('detalle_despacho'));
    }

    public function edit($id)
    {
        $detalle_despacho = Detalle_despacho::findOrFail($id);

        return view('admin.detalle_despacho.edit', compact('detalle_despacho'));
    }


    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $detalle_despacho = Detalle_despacho::findOrFail($id);
        $detalle_despacho->update($requestData);

        return redirect('admin/detalle_despacho')->with('correcto', 'Detalle_despacho updated!');
    }

    public function destroy($id)
    {
       Detalle_despacho::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/detalle_despacho')->with('correcto', 'Detalle_despacho deleted!');
    }

       public function reingresar($id)
    {
       Detalle_despacho::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/detalle_despacho')->with('correcto', 'Detalle_despacho deleted!');
    }
}
