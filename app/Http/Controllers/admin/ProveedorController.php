<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $proveedor = Proveedor::get();
        return view('admin.proveedor.index', compact('proveedor'))->with('correcto', 'correcto');
    }

    public function create()
    {
        return view('admin.proveedor.create');
    }

    public function store(Request $request)
    {

        $requestData = $request->all();
        Proveedor::create($requestData);
        return redirect('admin/proveedores')->with('correcto', 'Proveedor added!');
    }


    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('admin.proveedor.show', compact('proveedor'));
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('admin.proveedor.edit', compact('proveedor'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($requestData);
        return redirect('admin/proveedores')->with('correcto', 'Proveedor updated!');
    }


    public function destroy($id)
    {
        Proveedor::where('id', $id)->update(['estado' => '0']);

        return redirect('admin/proveedores')->with('correcto', 'Proveedor deleted!');
    }

    public function reingresar($id)
    {
        Proveedor::where('id', $id)->update(['estado' => '1']);

        // Cliente::destroy($id);

        return redirect('admin/proveedores')->with('correcto', 'Eliminado');
    }
}
