<?php

namespace App\PDF;

use Codedge\Fpdf\Fpdf\Fpdf;

class PlantillaProductosEnvasados extends Fpdf {
    protected $TITULO = 'REGISTRO DE PRODUCTOS ENVASADOS ..../.../';
    private $borderDev = 1; # solo para desarrollo = 1

    public $ALTURA_DATOS = 44;
    public $ALTURA_CELDA = 6.9;

    public $START_X = 9;

    private $DIA = '';
    private $MES = '';
    private $ANIO = '';

    public $START_X_ATTR = [
        'COL_1' => [
            'X' => 0,
            'WIDTH' => 12,
        ], # MAQUINA
        'COL_2' =>  [
            'X' => 0,
            'WIDTH' => 28,
        ], # NOMBRE
        'COL_3' => [
            'X' => 0,
            'WIDTH' => 30,
        ], # SABOR
        'COL_4' => [
            'X' => 0,
            'WIDTH' => 11,
        ], # BALDES, SALDO ANTERIOR
        'COL_5' => [
            'X' => 0,
            'WIDTH' => 13,
        ], # BALDES, CAMBIO DE MAQUINA
        'COL_6' => [
            'X' => 0,
            'WIDTH' => 13,
        ], # BALDES, ENTRADA DE MOLINO
        'COL_7' => [
            'X' => 0,
            'WIDTH' => 11,
        ], # BALDES, SOBRO DEL DIA
        'COL_8' => [
            'X' => 0,
            'WIDTH' => 13,
        ], # CAJAS, CAJAS
        'COL_9' => [
            'X' => 0,
            'WIDTH' => 11,
        ], # CAJAS, BOLSAS
        'COL_10' => [
            'X' => 0,
            'WIDTH' => 11,
        ], # SALIDAS O CAMBIOS, CAJAS
        'COL_11' => [
            'X' => 0,
            'WIDTH' => 11,
        ], # SALIDAS O CAMBIOS, BOLSAS
        'COL_12' => [
            'X' => 0,
            'WIDTH' => 20,
        ], # SALIDAS O CAMBIOS, FIRMA RESPONSABLE
        'COL_13' => [
            'X' => 0,
            'WIDTH' => 13.193,
        ], # BOBINAS, INGRESO
        'COL_14' => [
            'X' => 0,
            'WIDTH' => 13.193,
        ], # BOBINAS, MAL ESTADO
        'COL_15' => [
            'X' => 0,
            'WIDTH' => 17.4,
        ], # BOBINAS, SOBRANTES
        #************************************************
        'COL_16' => [
            'X' => 0,
            'WIDTH' => 7,
        ], # Problemas maquina
        'COL_17' => [
            'X' => 0,
            'WIDTH' => 7,
        ], # Operador
        'COL_18' => [
            'X' => 0,
            'WIDTH' => 7,
        ], # Sin novedad
        'COL_19' => [
            'X' => 0,
            'WIDTH' => 7,
        ], # Cambio de Producto
        'COL_20' => [
            'X' => 0,
            'WIDTH' => 7,
        ], # Producto Terminado

        # ********************************** ultimos
        'COL_21' => [
            'X' => 0,
            'WIDTH' => 20,
        ], # Firma
        'COL_22' => [
            'X' => 0,
            'WIDTH' => 13,
        ], # Producto Terminado
        'COL_23' => [
            'X' => 0,
            'WIDTH' => 40,
        ], # Observaciones
    ];

    function __construct(){
        parent::__construct('L', 'mm', 'Legal'); #oficio = Legal

        $this->SetFillColor(50, 255, 50);
        $this->SetFont('Arial', 'B', 12);
        $this->SetAutopageBreak(false, 0);
        $this->InicializaAnchoTabla();
    }

    public function Header(){
        $this->Line($this->START_X_ATTR['COL_1']['X'], 8, 345, 8);

        $this->Line($this->START_X_ATTR['COL_1']['X'], 8, $this->START_X_ATTR['COL_1']['X'], 20);
        $this->Line(345, 8, 345, 20);

        $this->SetXY(30, 10);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 9, utf8_decode($this->TITULO), $this->borderDev, 1, 'C');

        # ENCABEZADOS thead > th

        $ALTURA_HEAD = 20;
        $ALTURA_TH = 24;
        $FILL_TH = 0; # 0 or 1
        $this->SetFont('Times', 'B', 10); # Times
        $this->SetTextColor(0, 0, 0);
        $this->SetXY($this->START_X_ATTR['COL_1']['X'], $ALTURA_HEAD);
        $this->SetFillColor(240, 240, 240);
        $this->Cell($this->START_X_ATTR['COL_1']['WIDTH'], $ALTURA_TH, utf8_decode('MAQ.'), 1, 0, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_2']['X'], $ALTURA_HEAD);
        $this->Cell($this->START_X_ATTR['COL_2']['WIDTH'], $ALTURA_TH, utf8_decode('NOMBRE'), 1, 0, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_3']['X'], $ALTURA_HEAD);
        $this->Cell($this->START_X_ATTR['COL_3']['WIDTH'], $ALTURA_TH, utf8_decode('SABOR'), 1, 0, 'C', $FILL_TH);

        # ****************** BALDES *****************************************
        $this->SetXY($this->START_X_ATTR['COL_4']['X'], $ALTURA_HEAD);
        $this->MultiCell( $this->START_X_ATTR['COL_4']['WIDTH'] + $this->START_X_ATTR['COL_5']['WIDTH'] + $this->START_X_ATTR['COL_6']['WIDTH'] + $this->START_X_ATTR['COL_7']['WIDTH'],
            $ALTURA_TH /2 , utf8_decode('BALDES'), 1, 'C', $FILL_TH);

        $this->SetFont('Times', 'B', 7); # Times
        $this->SetXY($this->START_X_ATTR['COL_4']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_4']['WIDTH'], $ALTURA_TH /4 , utf8_decode('Sald Ant.'), 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_5']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_5']['WIDTH'], $ALTURA_TH /4 , utf8_decode('Cambio Maq.'), 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_6']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_6']['WIDTH'], $ALTURA_TH /4 , utf8_decode('Entrada Molino'), 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_7']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_7']['WIDTH'], $ALTURA_TH /4 , utf8_decode('Sobro del Dia'), 1, 'C', $FILL_TH);

        /* ****************** CAJAS **************************************** */

        $this->SetFont('Times', 'B', 10); # Times
        $this->SetXY($this->START_X_ATTR['COL_8']['X'], $ALTURA_HEAD);
        $this->MultiCell( $this->START_X_ATTR['COL_8']['WIDTH'] + $this->START_X_ATTR['COL_9']['WIDTH'],
            $ALTURA_TH /2 , utf8_decode('CAJAS'), 1, 'C', $FILL_TH);
        
        $this->SetFont('Times', 'B', 7); # Times
        $this->SetXY($this->START_X_ATTR['COL_8']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_8']['WIDTH'], $ALTURA_TH /2 , utf8_decode('Cajas'), 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_9']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_9']['WIDTH'], $ALTURA_TH /2 , utf8_decode('Bolsas'), 1, 'C', $FILL_TH);

        # ***************** SALIDAS O CAMBIOS ********************************

        $this->SetFont('Times', 'B', 10); # Times
        $this->SetXY($this->START_X_ATTR['COL_10']['X'], $ALTURA_HEAD);
        $this->MultiCell( $this->START_X_ATTR['COL_10']['WIDTH'] + $this->START_X_ATTR['COL_11']['WIDTH'] + $this->START_X_ATTR['COL_12']['WIDTH'],
            $ALTURA_TH /2 , utf8_decode('SALIDAS O CAMBIO'), 1, 'C', $FILL_TH);
        
        $this->SetFont('Times', 'B', 7); # Times
        $this->SetXY($this->START_X_ATTR['COL_10']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_10']['WIDTH'], $ALTURA_TH /2 , utf8_decode('Cajas'), 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_11']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_11']['WIDTH'], $ALTURA_TH /2 , utf8_decode('Bolsas'), 1, 'C', $FILL_TH);

        $this->SetFont('Times', 'B', 6); # Times
        $this->SetXY($this->START_X_ATTR['COL_12']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_12']['WIDTH'], $ALTURA_TH /2 , utf8_decode('Firma Responsable'), 1, 'C', $FILL_TH);

        /* ****************** BOBINA *************************************** */

        $this->SetFont('Times', 'B', 10); # Times
        $this->SetXY($this->START_X_ATTR['COL_13']['X'], $ALTURA_HEAD);
        $this->MultiCell( $this->START_X_ATTR['COL_13']['WIDTH'] + $this->START_X_ATTR['COL_14']['WIDTH'] + $this->START_X_ATTR['COL_15']['WIDTH'],
            $ALTURA_TH /2 , utf8_decode('BOBINAS'), 1, 'C', $FILL_TH);

        $this->SetFont('Times', 'B', 6); # Times
        $this->SetXY($this->START_X_ATTR['COL_13']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_13']['WIDTH'], $ALTURA_TH /2 , utf8_decode('Ingreso'), 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_14']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_14']['WIDTH'], $ALTURA_TH /2 , utf8_decode('Mal Estado'), 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_15']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_15']['WIDTH'], $ALTURA_TH /2 , utf8_decode('Sobrantes'), 1, 'C', $FILL_TH);

        # *******************************************************************************

        $this->SetXY($this->START_X_ATTR['COL_16']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_16']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_17']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_17']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_18']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_18']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_19']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_19']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_20']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_20']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);

        # *************************************** ULTIMOS ****************************

        $this->SetFont('Times', 'B', 10); # Times
        $this->SetXY($this->START_X_ATTR['COL_21']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_21']['WIDTH'], $ALTURA_TH, utf8_decode('FIRMA'), 1, 'C', $FILL_TH);

        $this->SetFont('Times', 'B', 5.5); # Times
        $this->SetXY($this->START_X_ATTR['COL_22']['X'], $ALTURA_HEAD);
        $this->MultiCell($this->START_X_ATTR['COL_22']['WIDTH'], $ALTURA_TH/2, utf8_decode('Devoluciones'), 1, 'C', $FILL_TH);

        $this->SetFont('Times', 'B', 7); # Times
        $this->SetXY($this->START_X_ATTR['COL_22']['X'], $ALTURA_HEAD + ($ALTURA_TH/2));
        $this->MultiCell($this->START_X_ATTR['COL_22']['WIDTH'], $ALTURA_TH/2, utf8_decode('Baldes'), 1, 'C', $FILL_TH);

        $this->SetFont('Times', 'B', 10); # Times
        $this->SetXY($this->START_X_ATTR['COL_23']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_23']['WIDTH'], $ALTURA_TH, utf8_decode('OBSERVACIONES'), 1, 'C', $FILL_TH);

    }

    public function SetDia($val =''){
        $this->DIA = $val;
    }

    public function SetMes($val =''){
        $this->MES = $val;
    }

    public function SetAnio($val =''){
        $this->ANIO = $val;
    }

    private function InicializaAnchoTabla(){
        $increment = $this->START_X;
        foreach($this->START_X_ATTR as $key => $data){
            $this->START_X_ATTR[$key]['X'] = $increment;
            $increment += $this->START_X_ATTR[$key]['WIDTH'];
        }
    }
}