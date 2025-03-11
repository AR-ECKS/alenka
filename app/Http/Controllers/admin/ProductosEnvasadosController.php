<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\PDF\PlantillaProductosEnvasados;
use App\PDF\PlantillaInventarioProductosEnvasados;

use App\Models\ProductosEnvasados;
use App\Models\Maquinas;

use App\Services\InventarioProductosEnvasadosService;

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

        $MAX_MAQUINAS = 2;

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

                # antiguo = true: formato solo se listan los productos envasados, false: se listan todas las maquinas, como maximo 2, y si exiten productos envasados
                if(true){
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
                        if($val->balde_saldo_anterior){
                            $total_saldo_anterior += $val->balde_saldo_anterior->balde_sobro_del_dia;
                        }

                        # baldes, cambio de maquina
                        $pdf->setFont('Arial', '', 7);
                        $pdf->SetXY($pdf->START_X_ATTR['COL_5']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                        $pdf->Cell($pdf->START_X_ATTR['COL_5']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        if($val->producto_cambio_de_maquina){
                            $total_cambio_de_maquina += $val->balde_cambio_de_maquina_baldes;
                        }

                        # baldes, entrada de molino
                        $pdf->setFont('Arial', '', 7);
                        $pdf->SetXY($pdf->START_X_ATTR['COL_6']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                        $pdf->Cell($pdf->START_X_ATTR['COL_6']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( ($val->entrada_cantidad_de_baldes > 0? $val->entrada_cantidad_de_baldes: '-') ), $borde_celda, 0, 'C');
                        if($val->entrada_cantidad_de_baldes > 0){
                            $total_entrada_de_molino += $val->entrada_cantidad_de_baldes;
                        }

                        # baldes, sobro del dia
                        $pdf->setFont('Arial', '', 7);
                        $pdf->SetXY($pdf->START_X_ATTR['COL_7']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                        $pdf->Cell($pdf->START_X_ATTR['COL_7']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->balde_sobro_del_dia)? '-': $val->balde_sobro_del_dia ), $borde_celda, 0, 'C');
                        if($val->balde_sobro_del_dia){
                            $total_sobro_del_dia += $val->balde_sobro_del_dia;
                        }

                        # cajas, cajas
                        $pdf->setFont('Arial', '', 7);
                        $pdf->SetXY($pdf->START_X_ATTR['COL_8']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                        $pdf->Cell($pdf->START_X_ATTR['COL_8']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->caja_cajas)? '-': $val->caja_cajas ), $borde_celda, 0, 'C');
                        if($val->caja_cajas){
                            $total_cajas += $val->caja_cajas; 
                        }

                        # cajas, bolsas
                        $pdf->setFont('Arial', '', 7);
                        $pdf->SetXY($pdf->START_X_ATTR['COL_9']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                        $pdf->Cell($pdf->START_X_ATTR['COL_9']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->caja_bolsas)? '-': $val->caja_bolsas ), $borde_celda, 0, 'C');
                        if($val->caja_bolsas){
                            $total_bolsas += $val->caja_bolsas; 
                        }

                        # observaciones
                        $pdf->setFont('Arial', '', 6);
                        #$val->observacion .= ' ademas de que existe rumores sobre la salida de contadores';
                        $pdf->SetXY($pdf->START_X_ATTR['COL_23']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                        $pdf->Cell($pdf->START_X_ATTR['COL_23']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode('' ), $borde_celda, 0, 'L');
                        $pdf->SetXY($pdf->START_X_ATTR['COL_23']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                        $pdf->MultiCell($pdf->START_X_ATTR['COL_23']['WIDTH'], 
                            $pdf->ALTURA_CELDA / (ceil($pdf->GetStringWidth( utf8_decode( $val->observacion ) ) / ($pdf->START_X_ATTR['COL_23']['WIDTH'] -2.5) ) == 0? 1: ceil($pdf->GetStringWidth( utf8_decode( $val->observacion ) ) / ($pdf->START_X_ATTR['COL_23']['WIDTH'] -2.5) )), 
                            utf8_decode( $val->observacion ), 0, 'L', 0);
                        
                        $contador++;
                    }
                    $new_contador = $contador;
                    /* if($contador%$pdf->MAX_FILAS==0){
                        $pdf->AddPage();
                        $new_contador = 0;
                    } */
                    for ($i=$new_contador; $i < $pdf->MAX_FILAS ; $i++) { 
                        $pdf->setFont('Arial', '', 7);

                        $pdf->SetXY($pdf->START_X_ATTR['COL_1']['X'], $pdf->ALTURA_DATOS + ($i * $pdf->ALTURA_CELDA));
                        $pdf->Cell($pdf->START_X_ATTR['COL_1']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( ''/* ($i+1) */ ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_2']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_3']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                        $pdf->Cell($pdf->START_X_ATTR['COL_4']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_5']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_6']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_7']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                        $pdf->Cell($pdf->START_X_ATTR['COL_8']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_9']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                        $pdf->Cell($pdf->START_X_ATTR['COL_10']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_11']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_12']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                        $pdf->Cell($pdf->START_X_ATTR['COL_13']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_14']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_15']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                        $pdf->Cell($pdf->START_X_ATTR['COL_16']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_17']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_18']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_19']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_20']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');

                        $pdf->Cell($pdf->START_X_ATTR['COL_21']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_22']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                        $pdf->Cell($pdf->START_X_ATTR['COL_23']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                    }

                    if($total_saldo_anterior > 0){
                        $pdf->SetTotalBaldeAnterior(round($total_saldo_anterior, 2));
                    }
                    if($total_cambio_de_maquina > 0){
                        $pdf->SetTotalCambioMaquina(round($total_cambio_de_maquina, 2));
                    }
                    if($total_entrada_de_molino > 0){
                        $pdf->SetTotalEntradaMolino(round($total_entrada_de_molino, 2));
                    }
                    if($total_sobro_del_dia > 0){
                        $pdf->SetTotalSobroDelDia(round($total_sobro_del_dia, 2));
                    }

                    if($total_cajas > 0){
                        $pdf->SetTotalCajasCajas(round($total_cajas, 2));
                    }
                    if($total_bolsas > 0){
                        $pdf->SetTotalCajasBolsas(round($total_bolsas, 2));
                    }
                } else {
                    # obtener maquinas
                    $maquinas = Maquinas::get();
                }
                $pdf->Output('I', $nombre_archivo);
                exit;
            } else {
                return;
            }
    }

    public function index_inventario(){
        return view('admin.inventario.index');
    }

    public function reporte_pdf_inventario_prod_envasados($anio = null, $mes = null, $dia = null){
        $consulta = new InventarioProductosEnvasadosService($anio, $mes, $dia);
        $registros = $consulta->get_inventario();

        if(count($registros) > 0){
            $subtitulo = 'REPORTE GENERAL';
            if($anio){
                if($mes){
                    if($dia){
                        $fecha_d = Carbon::createFromDate($anio, $mes, $dia);
                        $subtitulo = 'REPORTE DIARIO DEL '. mb_strtoupper($fecha_d->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY')); 
                    } else {
                        $fecha_m = Carbon::createFromDate($anio, $mes, null);
                        $subtitulo = 'REPORTE MENSUAL DE '. mb_strtoupper($fecha_m->locale('es')->isoFormat('MMMM \d\e\l YYYY'));  
                    }
                } else {
                    $subtitulo = 'REPORTE ANUAL DEL '. $anio;
                }
            }

            $titulo = 'Inventario de productos';
            $fecha_actual = Carbon::now();
            $pdf = new PlantillaInventarioProductosEnvasados();

            $pdf->SetTipoReporte($subtitulo);
            $pdf->SetFechaReporte($fecha_actual->locale('es')->isoFormat('dddd, D \d\e MMMM \d\e\l YYYY'));
            $pdf->SetHoraReporte($fecha_actual->locale('es')->isoFormat('HH:mm:ss'));

            $pdf->AddPage();
            $nombre_archivo = $titulo . ' '. $fecha_actual->locale('es')->isoFormat('dddd, YYYY-MM-DD') .'.pdf';

            $borde_celda = 1;

            $contador = 0;

            $pdf->SetFillColor(230, 230, 230);
            $pdf->SetDrawColor(180, 180, 180);
            foreach ($registros as $val) {
                $relleno_fila = $contador%2==0;
                # nro
                $pdf->setFont('Arial', 'B', 7);
                $pdf->SetXY($pdf->START_X_ATTR['COL_1']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                $pdf->Cell($pdf->START_X_ATTR['COL_1']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( ($contador+1) ), $borde_celda, 0, 'C', $relleno_fila);

                # codigo de sabor 
                $pdf->setFont('Arial', '', 7);
                $pdf->SetXY($pdf->START_X_ATTR['COL_2']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                $pdf->Cell($pdf->START_X_ATTR['COL_2']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( $val->codigo_producto ), $borde_celda, 0, 'L', $relleno_fila);
                
                # sabor
                $pdf->setFont('Arial', '', 7);
                $pdf->SetXY($pdf->START_X_ATTR['COL_3']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));                    
                $pdf->Cell($pdf->START_X_ATTR['COL_3']['WIDTH'], $pdf->ALTURA_CELDA, $val->sabor, $borde_celda, 1, 'L', $relleno_fila);

                # cantidad de cajas
                $pdf->setFont('Arial', '', 7);
                $pdf->SetXY($pdf->START_X_ATTR['COL_4']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                $pdf->Cell($pdf->START_X_ATTR['COL_4']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->total_cajas)? '-': $val->total_cajas ), $borde_celda, 0, 'C', $relleno_fila);

                # cantidad de bolsitas
                $pdf->setFont('Arial', '', 7);
                $pdf->SetXY($pdf->START_X_ATTR['COL_5']['X'], $pdf->ALTURA_DATOS + ($contador * $pdf->ALTURA_CELDA));
                $pdf->Cell($pdf->START_X_ATTR['COL_5']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( is_null($val->total_bolsas)? '-': $val->total_bolsas ), $borde_celda, 0, 'C', $relleno_fila);

                $contador++;
            }

            $new_contador = $contador;
            if($contador%$pdf->MAX_FILAS==0){
                $pdf->AddPage();
                $new_contador = 0;
            }
            for ($i=$new_contador; $i < $pdf->MAX_FILAS ; $i++) { 
                $pdf->setFont('Arial', '', 7);

                $pdf->SetXY($pdf->START_X_ATTR['COL_1']['X'], $pdf->ALTURA_DATOS + ($i * $pdf->ALTURA_CELDA));
                $pdf->Cell($pdf->START_X_ATTR['COL_1']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell($pdf->START_X_ATTR['COL_2']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell($pdf->START_X_ATTR['COL_3']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell($pdf->START_X_ATTR['COL_4']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
                $pdf->Cell($pdf->START_X_ATTR['COL_5']['WIDTH'], $pdf->ALTURA_CELDA, utf8_decode( '' ), $borde_celda, 0, 'C');
            }

            $pdf->SetTotalCajas($registros[0]->final_total_cajas);
            $pdf->SetTotalBolsitas($registros[0]->final_total_bolsas);

            $pdf->Output('I', $nombre_archivo);
            exit;
        } else {
            return;
        }
    }

}
