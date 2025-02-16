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
use App\Models\PreSalidaMolinos;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Detalle_Produccion;
use App\Models\SalidasDeMolino;

use App\PDF\PlantillaSalidaDeMolino;

class ProduccionController extends Controller
{

    public function index(Request $request)
    {
        $produccion  = Produccion::get();

        $listas_fecha = PreSalidaMolinos::where('estado', 1)
            ->groupBy('fecha')
            ->get();
        return view('admin.produccion.index', compact('produccion', 'listas_fecha'));
    }

    public function reporte_pdf_salida_molino($fecha = null){
        $titulo = 'Salida de Molino';
        $fecha_car = Carbon::create($fecha);
        $salidas_mol = SalidasDeMolino::where('fecha', $fecha)
            ->where('estado', '<>', 0)
            ->orderBy('turno')->get();
        if(count($salidas_mol) > 0){
            $pdf = new PlantillaSalidaDeMolino();
            $pdf->AddPage();
            $nombre_archivo = $titulo . ' '. $fecha_car->locale('es')->isoFormat('dddd, YYYY-MM-DD') .'.pdf';

            $borde_celda = 1;

            $tamanio_max_filas = 34;

            $contador = 0;
            $total_baldes = 0;
            foreach($salidas_mol as $salida){
                $pdf->setFont('Arial', '', 6);
                # fecha
                $pdf->SetXY(5, $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                $pdf->Cell(15, $pdf->ALTURA_CELDA, utf8_decode( $salida->fecha), $borde_celda, 0, 'L');

                # encargado de envasados
                $pdf->Cell(35, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'L');

                # firma 
                $pdf->Cell(15, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'L');

                # sabor
                $pdf->Cell(15, $pdf->ALTURA_CELDA, utf8_decode( $salida->sabor ), $borde_celda, 0, 'C');

                # cantidad de baldes 
                $pdf->Cell(35, $pdf->ALTURA_CELDA, utf8_decode( count($salida->detalle_salida_molinos) ), $borde_celda, 0, 'C');
                $total_baldes += count($salida->detalle_salida_molinos);

                # nombre => nombre del receptor
                $pdf->MultiCell(20, $pdf->ALTURA_CELDA , utf8_decode( $salida->recepcionista->username ), 1, 'C');

                # maquina
                $pdf->SetXY(140, $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                $pdf->MultiCell(20, $pdf->ALTURA_CELDA , utf8_decode( $salida->maquina->nombre ), 1, 'C');

                # firma del operador
                $pdf->SetXY(160, $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                $pdf->Cell(25, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                # para picar
                $pdf->Cell(25, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                # para sernir 
                $pdf->Cell(25, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                # observaciones
                $pdf->MultiCell(40, $pdf->ALTURA_CELDA , utf8_decode( $salida->observacion ), 1, 'L');


                $contador++;
            }

            $new_contador = $contador;
            if($contador%$tamanio_max_filas==0){
                $pdf->AddPage();
                $new_contador = 0;
            }
            for ($i=$new_contador; $i < $tamanio_max_filas ; $i++) { 
                $pdf->setFont('Arial', '', 6);

                $pdf->SetXY(5, $pdf->ALTURA_DATOS + ($i * $pdf->ALTURA_CELDA));
                $pdf->Cell(15, $pdf->ALTURA_CELDA, utf8_decode( ''/* . $i */), $borde_celda, 0, 'C');
                $pdf->Cell(35, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(15, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(15, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(35, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(20, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(20, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(25, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(25, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(25, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell(40, $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
            }

            $pdf->SetTotalBaldes($total_baldes);
            $pdf->Output('I', $nombre_archivo);
            exit;
        } else {
            return;
        }
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

    public function get_salidas_by_date($fecha = ''){
        $todo = PreSalidaMolinos::where('estado', 1)
            ->where('fecha', $fecha)
            ->orderBy('id_user', 'asc')
            ->orderBy('turno', 'asc')
            ->get();

        $all = [];
        foreach($todo as $t){
            $main = [
                'id' => $t->id,
                'codigo' => $t->codigo,
                'fecha' => $t->fecha,
                'turno' => $t->turno,
                'observacion' => $t->observacion,
                'baldes' => $t->baldes,
                'cantidad' => $t->cantidad,
                'nombre' => $t->recepcionista->username,
                'maquina' => $t->recepcionista->maquina,
                'sabor' => $t->proceso->despacho->sabor
                /* 'id' => $t->
                'id' => $t->
                'id' => $t->
                'id' => $t->
                'id' => $t->
                'id' => $t-> */
            ];
            array_push($all, $main );
        }
        return response()->json([
            'success' => true,
            'message' => 'Se recuperaron '. count($todo) .' registros',
            'data' => $all
        ]);
    }
}
