<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Proceso;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Despacho;
use App\Models\Detalle_despacho;
use App\Notifications\DesviacionNotificacion;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class ProcesoController extends Controller
{

    public function index(Request $request)
    {
        $proceso  = Proceso::get();
        return view('admin.proceso.index', compact('proceso'));
    }


    public function create()
    {
        $fechaActual = now()->format('Y-m-d'); // Obtener la fecha actual en formato YYYY-MM-DD
        $despachos = Despacho::where('estado', 1)
        ->where('tipo', 1)
            ->whereDate('created_at', $fechaActual)
            ->get();
        $codigo = $this->generarCodigoProceso();

        return view('admin.proceso.create', compact('codigo', 'despachos'));
    }



    private function generarCodigoProceso()
    {
        $fechaActual = Carbon::now();
        $dia = $fechaActual->format('d');
        $mes = strtoupper($fechaActual->format('M'));
        $anio = $fechaActual->format('Y');

        $ultimoProceso = Proceso::whereDate('created_at', $fechaActual->toDateString())
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimoProceso) {
            $ultimoCodigo = $ultimoProceso->codigo;
            $partes = explode('-', $ultimoCodigo);
            $numeroProceso = (int) $partes[1] + 1;
        } else {
            $numeroProceso = 1;
        }

        return "PR-{$numeroProceso}-{$dia}-{$mes}-{$anio}";
    }

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'baldes' => 'required|integer',
            'cantidad' => 'required|numeric',
            'cantidad_incompleto' => ['required_if:incompleto,true']
        ]);

        // Calcular total de kilogramos
        $totalKg = ($request->baldes * $request->cantidad) + $request->cantidad_incompleto;

        // Calcular total_baldes con un decimal
        $totalBaldes = $request->baldes + round($request->cantidad_incompleto / $request->cantidad, 1);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Crear un nuevo proceso con los datos del request y los cálculos realizados
        $proceso = Proceso::create([
            'created_at' => now(),
            'despacho_id' => $request->despacho_id,
            'codigo' => $request->codigo,
            'observacion' => $request->observacion,
            'fecha' => $request->fecha,
            'baldes' => $request->baldes,
            'incompleto' => $request->incompleto,
            'cantidad_incompleto' => $request->cantidad_incompleto,
            'cantidad' => $request->cantidad,
            'total' => $totalKg,
            'total_cantidad' => $totalKg,
            'total_baldes' => $totalBaldes,
            'estado' => $request->estado,
            'user_id' => $userId,
        ]);

        // Obtener el despacho correspondiente
        $despacho = Despacho::where('id', $request->despacho_id)->first();
        if ($despacho) {
            $despacho->estado = 2;
            $despacho->save();
        }


        // Comparar totales
        $desviacion = abs($despacho->total - $totalKg);
        if ($desviacion > 50) {
            Notification::send(Auth::user(), new DesviacionNotificacion($desviacion));
        }

        // Redireccionar con mensaje de éxito
        return redirect('admin/proceso')->with('correcto', 'Proceso añadido correctamente.');
    }



    public function getDetalleDespacho(Request $request)
    {
        $despachoId = $request->despacho_id;
        $detallesDespacho = Detalle_Despacho::where('despacho_id', $despachoId)
            ->with('materia_prima') // Cargar relación materia_prima
            ->get();

        return response()->json($detallesDespacho);
    }



    public function show($id)
    {
        $proceso = Proceso::findOrFail($id);

        return view('admin.proceso.show', compact('proceso'));
    }

    public function edit($id)
    {
        $fechaActual = now()->format('Y-m-d'); // Obtener la fecha actual en formato YYYY-MM-DD
        $proceso = Proceso::findOrFail($id);
        $despachos = Despacho::where('estado', 1)
        ->where('tipo', 1)
            ->whereDate('created_at', $fechaActual)
            ->orWhere('id', $proceso->despacho_id)
            ->get();
        $codigo = $proceso->codigo;

        return view('admin.proceso.edit', compact('proceso', 'despachos', 'codigo'));
    }


    public function update(Request $request, $id)
    {

        $requestData = $request->all();

        $proceso = Proceso::findOrFail($id);
        $proceso->update($requestData);

        return redirect('admin/proceso')->with('correcto', 'Proceso updated!');
    }

    public function destroy($id)
    {
        Proceso::where('id', $id)->update(['estado' => '0']);
        return redirect('admin/proceso')->with('correcto', 'Proceso deleted!');
    }

    public function reingresar($id)
    {
        Proceso::where('id', $id)->update(['estado' => '1']);
        return redirect('admin/proceso')->with('correcto', 'Proceso deleted!');
    }
}
