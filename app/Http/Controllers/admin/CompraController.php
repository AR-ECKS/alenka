<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Compra;
use App\Models\Detalle_compra;

use App\Models\Materia_prima;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class CompraController extends Controller
{

    public function index(Request $request)
    {
        $compra  = Compra::get();
        return view('admin.compra.index', compact('compra'));
    }


    public function create()
    {
        $proveedores = Proveedor::get();
        $codigoCompra = $this->generarCodigoCompra();
        return view('admin.compra.create', compact('codigoCompra', 'proveedores'));
    }



    public function generarCodigoCompra()
    {
        // Obtener el último valor de numero_compra
        $ultimaCompra = Compra::orderBy('id', 'desc')->first();

        // Definir el prefijo del código
        $prefijo = 'CC';

        // Definir el correlativo inicial
        $correlativoInicial = 1;

        // Generar el nuevo código de compra
        if ($ultimaCompra) {
            // Extraer el número del último codigo
            $ultimoNumero = intval(substr($ultimaCompra->numero_compra, 3));
            $correlativo = $ultimoNumero + 1;
        } else {
            $correlativo = $correlativoInicial;
        }

        // Formatear el correlativo con ceros a la izquierda
        $correlativoFormateado = str_pad($correlativo, 5, '0', STR_PAD_LEFT);

        // Construir el código completo
        $codigoCompra = $prefijo . '-' . $correlativoFormateado;

        return $codigoCompra;
    }



    public function getStates(Request $request)
    {
        $productos = Materia_prima::where('proveedor_id', $request->proveedor_id)
            ->get();
        if (count($productos) > 0) {
            return response()->json($productos);
        }
    }

    public function store(Request $request)
    {
        // dd($request);
        try {
            DB::beginTransaction();

            $id_user = auth()->user()->id;
            $ids = auth()->user()->empresa_id;
            $nrodoc = $request->get('numero_compra');
            $compraExistente = Compra::where('numero_compra', $nrodoc)->first();

            if ($compraExistente) {
                Session::flash('success_message2', 'Compra registrada correctamente');
                Session::flash('nrodoc', $nrodoc);
                return redirect()->back();
            }

            $totalCompra = $request->get('totalc');
            $formaPago = $request->get('forma_pago');

            $compra = new Compra;
            $compra->numero_compra = $request->get('codigo');
            $compra->factura = $request->get('factura');
            $compra->fecha = $request->get('fecha_compra');
            $compra->proveedor_id = $request->get('proveedor_id');
            $compra->user_id = $id_user;
            $compra->total = $totalCompra;
            $compra->forma_pago = $formaPago;
            $compra->save();

            $producto_id = $request->get('producto_id');
            $cantidad_presentacion = $request->get('cantidad_presentacion');
            $cantidad_unidad = $request->get('cantidad_unidad');
            $precios_compra = $request->get('precios_compra');

            for ($i = 0; $i < count($producto_id); $i++) {

                $producto = Materia_prima::findOrFail($producto_id[$i]);
                $detalle = new Detalle_compra();
                $detalle->compra_id = $compra->id;
                $detalle->cantidad_presentacion = $cantidad_presentacion[$i];
                $detalle->cantidad_unidad = $cantidad_unidad[$i];
                $detalle->precio_real_presentacion = $precios_compra[$i];
                $detalle->materia_prima_id = $producto_id[$i];
                $detalle->save();

                // Actualizar stock del producto
                $producto->stock_presentacion += $cantidad_presentacion[$i];
                $producto->stock_unidad += $cantidad_unidad[$i];
                $producto->save();
            }

            DB::commit();
            Session::flash('success_message', 'Compra registrada correctamente');
            return redirect('admin/compra')->with('correcto', 'La compra se ha guardado correctamente.');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error_message', 'Ocurrió un error al guardar la compra. Por favor, inténtalo nuevamente.');
            return redirect('admin/compra')->with('error', 'Ocurrió un error al guardar la compra. Por favor, inténtalo nuevamente.');
        }
    }



    public function show($id)
    {
        $compra = Compra::findOrFail($id);
        $detalles = Detalle_compra::where('compra_id', $id)->get(); // Obtener detalles de la compra

        return view('admin.compra.show', compact('compra', 'detalles')); // Pasar detalles a la vista
    }


    public function edit($id)
    {
        $compra = Compra::findOrFail($id);

        return view('admin.compra.edit', compact('compra'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $compra = Compra::findOrFail($id);
        $compra->update($requestData);

        return redirect('admin/compra')->with('correcto', 'Compra updated!');
    }

    public function destroy($id)
    {
       Compra::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/compra')->with('correcto', 'Compra deleted!');
    }

       public function reingresar($id)
    {
       Compra::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/compra')->with('correcto', 'Compra deleted!');
    }
}
