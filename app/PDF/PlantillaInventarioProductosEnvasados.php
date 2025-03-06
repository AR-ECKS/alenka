<?php

namespace App\PDF;

use Codedge\Fpdf\Fpdf\Fpdf;

use Illuminate\Support\Str;

class PlantillaInventarioProductosEnvasados extends Fpdf {

    protected $TITULO = 'INVENTARIO DE PRODUCTOS ENVASADOS "ALENKA SRL"';
    private $borderDev = 0; # solo para desarrollo = 1

    public $ALTURA_DATOS = 35; # 44
    public $ALTURA_CELDA = 6; #6.9

    public $START_X = 9;

    private $TIPO_REPORTE = '';

    public $MAX_FILAS = 25;

    public $START_X_ATTR = [
        'COL_1' => [
            'X' => 0,
            'WIDTH' => 12,
        ], # NRO
        'COL_2' =>  [
            'X' => 0,
            'WIDTH' => 50,
        ], # CODIGO DE PRODUCTO
        'COL_3' => [
            'X' => 0,
            'WIDTH' => 50,
        ], # SABOR
        'COL_4' => [
            'X' => 0,
            'WIDTH' => 40,
        ], # CANTIDAD DE CAJAS
        'COL_5' => [
            'X' => 0,
            'WIDTH' => 40,
        ], # CANTIDAD DE BOLSITAS
        'COL_6' => [
            'X' => 0,
            'WIDTH' => 13,
        ], 
    ];

    private $FECHA_REPORTE = '';
    private $HORA_REPORTE = '';

    private $TOTAL_CAJAS = '';
    private $TOTAL_BOLSITAS = '';

    function __construct(){
        parent::__construct('L', 'mm', 'Letter'); #carta

        $this->SetFillColor(50, 255, 50);
        $this->SetFont('Arial', 'B', 12);
        $this->SetAutopageBreak(false, 0);
        $this->InicializaAnchoTabla();
    }

    public function Header(){
        # insertar imagen
        $image = Str::finish(public_path(), DIRECTORY_SEPARATOR) . 'img' . DIRECTORY_SEPARATOR . 'logo.png'; #public_path(). '/img/logo.png';
        if(file_exists($image)){
            $this->Image($image, 10, 5, 0, 18);
            /* $this->Text(5, 5, 'Es'. $image); */
        }

        $this->SetXY(30, 10);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 9, utf8_decode($this->TITULO), $this->borderDev, 1, 'C');

        # fecha y hora de reporte
        if($this->FECHA_REPORTE){
            $this->SetTextColor(100, 100, 100);
            $this->SetFont('Times', '', 7); 
            $this->SetXY($this->START_X_ATTR['COL_1']['X'], 19);
            $this->Cell(60, 4, utf8_decode( 'Fecha de reporte: '. $this->FECHA_REPORTE ), $this->borderDev, 0, 'L');
        }
        if($this->HORA_REPORTE){
            $this->SetTextColor(100, 100, 100);
            $this->SetFont('Times', '', 7); 
            $this->SetXY($this->START_X_ATTR['COL_1']['X'], 23);
            $this->Cell(60, 4, utf8_decode( 'Hora de reporte: '. $this->HORA_REPORTE ), $this->borderDev, 0, 'L');
        }

        # tipo de reporte
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Times', 'B', 15); 
        $this->SetXY(70, 20);
        $this->Cell(190, 6, utf8_decode( $this->TIPO_REPORTE ), $this->borderDev, 0, 'C');

        # ENCABEZADOS thead > th

        $ALTURA_HEAD = 28;
        $ALTURA_TH = 7;
        $FILL_TH = 1; # 0 or 1
        $this->SetFont('Times', 'B', 10); # Times
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(29, 136, 123);
        $this->SetDrawColor(180, 180, 180);
        $this->SetXY($this->START_X_ATTR['COL_1']['X'], $ALTURA_HEAD);
        $this->Cell($this->START_X_ATTR['COL_1']['WIDTH'], $ALTURA_TH, utf8_decode('#'), 1, 0, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_2']['X'], $ALTURA_HEAD);
        $this->Cell($this->START_X_ATTR['COL_2']['WIDTH'], $ALTURA_TH, utf8_decode('CÓDIGO DE SABOR'), 1, 0, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_3']['X'], $ALTURA_HEAD);
        $this->Cell($this->START_X_ATTR['COL_3']['WIDTH'], $ALTURA_TH, utf8_decode('SABOR'), 1, 0, 'C', $FILL_TH);

        # ****************** BALDES *****************************************
        $this->SetXY($this->START_X_ATTR['COL_4']['X'], $ALTURA_HEAD);
        $this->Cell($this->START_X_ATTR['COL_4']['WIDTH'], $ALTURA_TH, utf8_decode('CANTIDAD CAJAS'), 1, 0, 'C', $FILL_TH);

        $this->SetXY($this->START_X_ATTR['COL_5']['X'], $ALTURA_HEAD);
        $this->Cell($this->START_X_ATTR['COL_5']['WIDTH'], $ALTURA_TH, utf8_decode('CANTIDAD BOLSITAS'), 1, 0, 'C', $FILL_TH);
        
    }

    public function Footer(){
        $this->SetFont('Times', 'B', 10); # Times
        $this->SetTextColor(255, 255, 255);
        $this->SetXY($this->START_X_ATTR['COL_1']['X'], $this->ALTURA_DATOS + $this->ALTURA_CELDA * $this->MAX_FILAS);
        $this->SetFillColor(90, 90, 90);
        $this->Cell($this->START_X_ATTR['COL_1']['WIDTH'] + $this->START_X_ATTR['COL_2']['WIDTH'] + $this->START_X_ATTR['COL_3']['WIDTH'], 
            $this->ALTURA_CELDA, utf8_decode('TOTAL'), 1, 0, 'R', 1);
        
        $this->SetXY($this->START_X_ATTR['COL_4']['X'], $this->ALTURA_DATOS + $this->ALTURA_CELDA * $this->MAX_FILAS);
        $this->Cell($this->START_X_ATTR['COL_4']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_CAJAS ), 1, 0, 'C', 1);

        $this->SetXY($this->START_X_ATTR['COL_5']['X'], $this->ALTURA_DATOS + $this->ALTURA_CELDA * $this->MAX_FILAS);
        $this->Cell($this->START_X_ATTR['COL_5']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_BOLSITAS ), 1, 0, 'C', 1);
    }

    private function ProcesarTitulo(){
        
    }

    public function SetTotalCajas($val = ''){
        $this->TOTAL_CAJAS = $val;
    }

    public function SetTotalBolsitas($val = ''){
        $this->TOTAL_BOLSITAS = $val;
    }

    public function SetFechaReporte($val = ''){
        $this->FECHA_REPORTE = $val;
    }

    public function SetHoraReporte($val = ''){
        $this->HORA_REPORTE = $val;
    }

    public function SetTipoReporte($val = ''){
        $this->TIPO_REPORTE = $val;
    }

    private function InicializaAnchoTabla(){
        $increment = $this->START_X;
        foreach($this->START_X_ATTR as $key => $data){
            $this->START_X_ATTR[$key]['X'] = $increment;
            $increment += $this->START_X_ATTR[$key]['WIDTH'];
        }
    }
    
}