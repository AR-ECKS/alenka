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
                    $maq = trim($val->maquina->nombre);
                    $maq_fin = mb_strtoupper($maq);
                    if(mb_strlen($maq) >= 5){
                        $part = explode( ' ', $maq_fin);
                        if(count($part) >= 2){
                            $maq_fin = ((mb_strlen($part[0])> 4 )? mb_substr($part[0], 0, 3): $part[0])
                                . ' '. mb_substr($part[count($part) - 1], -1);
                        }
                    }
                    $pdf->setFont('Arial', 'B', 6);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_1']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_1']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( $maq_fin/* 'MAQ 1' */ ), $borde_celda, 0, 'L');

                    # nombre 
                    if(is_null($val->encargado)) {
                        $this->SetTextColor(255, 0, 0);
                        $val->encargado->username = 'SIN OPERADOR';
                    }
                    $pdf->setFont('Arial', '', 7);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_2']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_2']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( $val->encargado->username ), $borde_celda, 0, 'C');
                    
                    # sabor
                    $pdf->setFont('Arial', '', 7);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_3']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));                    
                    $pdf->CellFitScale($pdf->START_X_ATTR['COL_3']['WIDTH'], $pdf->ALTURA_CELDA, $val->sabor, $borde_celda, 1, 'C');

                    # baldes, saldo anterior
                    $pdf->setFont('Arial', '', 7);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_4']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_4']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->balde_saldo_anterior)? '-': $val->producto_saldo_anterior->balde_sobro_del_dia ), $borde_celda, 0, 'C');

                    # baldes, cambio de maquina
                    $pdf->setFont('Arial', '', 7);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_5']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_5']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                    # baldes, entrada de molino
                    $total_baldes = 0;
                    foreach ($val->salidas_de_molino as $sal_mol ) {
                        $total_baldes += count($sal_mol->detalle_salida_molinos);
                    }
                    $pdf->setFont('Arial', '', 7);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_6']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_6']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( $total_baldes ), $borde_celda, 0, 'C');

                    # baldes, sobro del dia
                    $pdf->setFont('Arial', '', 7);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_7']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_7']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->balde_sobro_del_dia)? '-': $val->balde_sobro_del_dia ), $borde_celda, 0, 'C');

                    # cajas, cajas
                    $pdf->setFont('Arial', '', 7);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_8']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_8']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->caja_cajas)? '-': $val->caja_cajas ), $borde_celda, 0, 'C');

                    # cajas, bolsas
                    $pdf->setFont('Arial', '', 7);
                    $pdf->SetXY($pdf->START_X_ATTR['COL_9']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_9']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->caja_bolsas)? '-': $val->caja_bolsas ), $borde_celda, 0, 'C');

                    # observaciones
                    $pdf->setFont('Arial', '', 6);
                    #$val->observacion .= ' ademas de que existe rumores sobre la salida de contadores';
                    $pdf->SetXY($pdf->START_X_ATTR['COL_23']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->Cell($pdf->START_X_ATTR['COL_23']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode('' ), $borde_celda, 0, 'L');
                    $pdf->SetXY($pdf->START_X_ATTR['COL_23']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                    $pdf->MultiCell($pdf->START_X_ATTR['COL_23']['WIDTH'], 
                        $pdf->ALTURA_CELDA / ceil($pdf->GetStringWidth( utf8_decode( $val->observacion ) ) / ($pdf->START_X_ATTR['COL_23']['WIDTH'] -2.5) ) , 
                        utf8_decode( $val->observacion ), 0, 'L', 0);
                }

                $pdf->Output('I', $nombre_archivo);
                exit;
            } else {
                return;
            }
    }

}
