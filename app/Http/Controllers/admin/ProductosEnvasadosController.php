<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\PDF\PlantillaProductosEnvasados;

use App\Models\ProductosEnvasados;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;

class ProductosEnvasadosController extends Controller
{

    public function index()
    {
        return view('admin.producto_envasado.index');
    }

    public function reporte_pdf_productos_envasados($fecha = null){
        $titulo = 'Registro de productos ';
        $fecha_car = null;
        try {
            $fecha_car = Carbon::create($fecha);
        } catch (InvalidFormatException $e) {
            //echo "La fecha no es válida.";
            return;
        }

        $registro_productos = ProductosEnvasados::where('fecha', $fecha)
            ->where('estado', '<>', 0)
            ->orderBy('maquina_id')->get();
        
            if(count($registro_productos) > 0){
                $pdf = new PlantillaProductosEnvasados();
                
                $pdf->SetDia($fecha_car->isoFormat('DD'));
                $pdf->SetMes($fecha_car->isoFormat('MM'));
                $pdf->SetAnio($fecha_car->isoFormat('YYYY'));
                $pdf->AddPage();
                $nombre_archivo = $titulo . ' '. $fecha_car->locale('es')->isoFormat('dddd, YYYY-MM-DD') .'.pdf';

                $pdf->Output('I', $nombre_archivo);
                exit;
            } else {
                return;
            }
    }

}
