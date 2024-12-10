<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Detalle_compra;
use Illuminate\Http\Request;

class Detalle_compraController extends Controller
{

    public function index(Request $request)
    {
        $detalle_compra  = Detalle_compra::get();
        return view('admin.detalle_compra.index', compact('detalle_compra'));
    }


    public function create()
    {
        return view('admin.detalle_compra.create');
    }


    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Detalle_compra::create($requestData);

        return redirect('admin/detalle_compra')->with('correcto', 'Detalle_compra added!');
    }


    public function show($id)
    {
        $detalle_compra = Detalle_compra::findOrFail($id);

        return view('admin.detalle_compra.show', compact('detalle_compra'));
    }

    public function edit($id)
    {
        $detalle_compra = Detalle_compra::findOrFail($id);

        return view('admin.detalle_compra.edit', compact('detalle_compra'));
    }


    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $detalle_compra = Detalle_compra::findOrFail($id);
        $detalle_compra->update($requestData);

        return redirect('admin/detalle_compra')->with('correcto', 'Detalle_compra updated!');
    }

    public function destroy($id)
    {
       Detalle_compra::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/detalle_compra')->with('correcto', 'Detalle_compra deleted!');
    }

       public function reingresar($id)
    {
       Detalle_compra::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/detalle_compra')->with('correcto', 'Detalle_compra deleted!');
    }
}
