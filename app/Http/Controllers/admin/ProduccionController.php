<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Produccion;
use Illuminate\Http\Request;
use App\Models\Materia_prima;
use Carbon\Carbon;
use App\Models\Despacho;
use App\Models\User;
use App\Models\Proceso;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Detalle_Produccion;

class ProduccionController extends Controller
{

    public function index(Request $request)
    {
        $produccion  = Produccion::get();
        return view('admin.produccion.index', compact('produccion'));
    }

    public function creates($id)
    {
        $fechaActual = Carbon::now();
        $dia = $fechaActual->format('d');
        $mes = strtoupper($fechaActual->format('M'));
        $anio = $fechaActual->format('Y');

        $ultimaEntrega = Despacho::whereDate('created_at', $fechaActual->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        $numeroEntrega = $ultimaEntrega ? ((int) explode('-', $ultimaEntrega->codigo)[1] + 1) : 1;

        $codigo = "EM-{$numeroEntrega}-{$dia}-{$mes}-{$anio}";

        $usuarios = User::where('tipo', 2)->get();
        $proceso = Proceso::find($id);

        if (!$proceso) {
            return redirect()->back()->withErrors(['error' => 'Proceso no encontrado.']);
        }

        // Calcular el total de kilogramos y baldes disponibles
        //$total_kg = $proceso->baldes * $proceso->cantidad + $proceso->cantidad_incompleto;
        //$total_baldes = round($total_kg / $proceso->cantidad, 1);

        // Procesos, Produccions, detalle_produccions
        $lista_detalles_produccion = DB::table('produccions')
            ->join('detalle_produccions', 'produccions.id', '=', 'detalle_produccions.produccion_id')
            ->where('produccions.proceso_id', '=', $proceso->id)
            ->groupBy('produccions.id')
            ->get();
        $fin_total_kg = $proceso->baldes * $proceso->cantidad + $proceso->cantidad_incompleto;
        $fin_total_baldes = round($fin_total_kg / $proceso->cantidad, 1);
        $total_kg = $fin_total_kg;
        $total_baldes = $fin_total_baldes;
        foreach($lista_detalles_produccion as $det_prod){
            $total_kg -= $det_prod->cantidad;
            $total_baldes -= $det_prod->baldes;
        }

        return view('admin.produccion.create', compact('codigo', 'usuarios', 'proceso', 'total_baldes', 'total_kg', 'lista_detalles_produccion', 'fin_total_kg', 'fin_total_baldes'));
    }



    public function store(Request $request)
    {
        // Decodificar el carrito de JSON a array
        $carrito = json_decode($request->carrito, true);

        DB::beginTransaction();

        try {
            // Obtener el ID del usuario autenticado
            $userId = Auth::id();

            // Crear una nueva producción
            if(count($carrito) > 0){
                $produccion = Produccion::create([
                    'codigo' => $request->codigo,
                    'fecha' => $request->fecha,
                    'proceso_id' => $request->proceso_id,
                    'user_id' => $userId, // Usuario actualmente autenticado
                    'sabor' => $request->sabor,
                    'observacion' => $request->observacion
                ]);

                // Variables para acumular la cantidad total de baldes y kilos
                $totalBaldesUtilizados = 0;
                $totalKilosUtilizados = 0;

                // Recorrer el carrito y crear los detalles de la producción
                foreach ($carrito as $item) {
                    Detalle_Produccion::create([
                        'produccion_id' => $produccion->id,
                        'user_id' => $item['operadorId'], // Usuario operador del detalle
                        'baldes' => $item['cantidadBaldes'],
                        'cantidad' => $item['cantidadKilos']
                    ]);

                    // Acumular la cantidad total de baldes y kilos utilizados
                    $totalBaldesUtilizados += $item['cantidadBaldes'];
                    $totalKilosUtilizados += $item['cantidadKilos'];
                }

                // Obtener el proceso correspondiente
                $proceso = Proceso::find($request->proceso_id);

                // Restar la cantidad total de baldes y kilos utilizados
                $proceso->total_baldes -= $totalBaldesUtilizados;
                $proceso->total_cantidad -= $totalKilosUtilizados;

                // Guardar los cambios en el proceso
                $proceso->save();
                DB::commit();
                return redirect('admin/produccion')->with('correcto', 'Proceso añadido correctamente.');
            } else {
                return redirect('admin/produccion')->with('correcto', 'No se agrego nada.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('admin/produccion')->with('error', 'Ocurrio un error, restaurando.'. $e->getMessage());
        }
    }

    public function show($id)
    {
        $produccion = Produccion::findOrFail($id);

        return view('admin.produccion.show', compact('produccion'));
    }

    public function edit($id)
    {
        $produccion = Produccion::findOrFail($id);
        $usuarios = User::with('roles')->where('tipo', 2)->get(); // Cargar los usuarios con sus roles

        $codigo = $produccion->codigo;
        $proceso = Proceso::find($produccion->proceso_id );

        return view('admin.produccion.edit', compact('produccion', 'usuarios', 'codigo', 'proceso'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $produccion = Produccion::findOrFail($id);
        $produccion->update($requestData);

        return redirect('admin/produccion')->with('correcto', 'Produccion updated!');
    }

    public function destroy($id)
    {
       Produccion::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/produccion')->with('correcto', 'Produccion deleted!');
    }

       public function reingresar($id)
    {
       Produccion::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/produccion')->with('correcto', 'Produccion deleted!');
    }
}
