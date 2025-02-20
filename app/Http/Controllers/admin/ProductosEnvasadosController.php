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

                $borde_celda = 1;

                $tamanio_max_filas = 20;
                $contador = 0;

                $total_saldo_anterior = 0;
                $total_cambio_de_maquina = 0;
                $total_entrada_de_molino = 0;
                $total_sobro_del_dia = 0;
                $total_cajas = 0;
                $total_bolsas = 0;

                foreach ($registro_productos as $val) {
                    # MAQ.
                    $pdf->setFont('Arial', 'B', 6);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_1']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_1']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( 'MAQ 1' ), $borde_celda, 0, 'L');
                }

                $pdf->Output('I', $nombre_archivo);
                exit;
            } else {
                return;
            }
    }

}
