<?php

namespace App\PDF;

use Codedge\Fpdf\Fpdf\Fpdf;

use Illuminate\Support\Str;

class PlantillaSalidaDeMolino extends Fpdf {

    protected $titulo = 'SALIDAS DE MOLINO';
    private $borderDev = 0; # solo para desarrollo = 1

    public $ALTURA_DATOS = 38;
    public $ALTURA_CELDA = 4.9;

    # atributes
    private $TOTAL_BALDES = '';
    private $TOTAL_PARA_PICAR = '';
    private $FECHA_REPORTE = '';
    PRIVATE $ANIO_REPORTE = '';

    function __construct(){
        parent::__construct('L', 'mm', 'Letter'); #carta

        $this->SetFillColor(50, 255, 50);
        $this->SetFont('Arial', 'B', 12);
        $this->SetAutopageBreak(false, 0);
    }

    public function Header(){
        # insertar imagen
        $image = Str::finish(public_path(), DIRECTORY_SEPARATOR) . 'img' . DIRECTORY_SEPARATOR . 'logo.png'; #public_path(). '/img/logo.png';
        if(file_exists($image)){
            $this->Image($image, 10, 5, 0, 18);
            /* $this->Text(5, 5, 'Es'. $image); */
        }

        $this->SetXY(30, 10);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(0, 9, utf8_decode($this->titulo), $this->borderDev, 1, 'C');

        $this->SetXY(30, 19);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(90, 5, utf8_decode('MES: '. str_pad('', 60, '.')), $this->borderDev, 1, 'L');

        $this->SetXY(40, 18.4);
        $this->SetFont('Arial', '',10);
        $this->Cell(80, 5, utf8_decode($this->FECHA_REPORTE), $this->borderDev, 1, 'L');

        $this->SetXY(140, 19);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(40, 5, utf8_decode( $this->ANIO_REPORTE/* '2023' */), $this->borderDev, 1, 'C');

        # ENCABEZADOS thead > th

        $ALTURA_HEAD = 28;
        $ALTURA_TH = 10;
        $this->SetFont('Times', 'B', 10); # Times
        $this->SetTextColor(255, 255, 255);
        $this->SetXY(5, $ALTURA_HEAD);
        $this->SetFillColor(50, 50, 50);
        $this->Cell(15, $ALTURA_TH, utf8_decode('FECHA'), 1, 0, 'C', 1);
        $this->MultiCell(35, $ALTURA_TH /2 , utf8_decode('ENCARGADO DE EMBASADOS'), 1, 'C', 1);

        $this->SetXY(5+15+35, $ALTURA_HEAD);
        $this->Cell(15, $ALTURA_TH, utf8_decode('FIRMA'), 1, 0, 'C', 1);
        $this->Cell(15, $ALTURA_TH, utf8_decode('SABOR'), 1, 0, 'C', 1);
        $this->MultiCell(35, $ALTURA_TH /2 , utf8_decode('CANTIDAD DE BALDES'), 1, 'C', 1);

        $this->SetXY(5+15+35+15+15+35, $ALTURA_HEAD);
        $this->Cell(20, $ALTURA_TH, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
        $this->Cell(20, $ALTURA_TH, utf8_decode('MAQUINA'), 1, 0, 'C', 1);
        $this->MultiCell(25, $ALTURA_TH /2 , utf8_decode('FIRMA OPERADOR'), 1, 'C', 1);

        $this->SetXY(5+15+35+15+15+35+20+20+25, $ALTURA_HEAD);
        $this->Cell(25, $ALTURA_TH, utf8_decode('PARA PICAR'), 1, 0, 'C', 1);
        $this->Cell(25, $ALTURA_TH, utf8_decode('PARA SERNIR'), 1, 0, 'C', 1);
        $this->Cell(40, $ALTURA_TH, utf8_decode('OBSERVACIONES'), 1, 0, 'C', 1);
    }

    public function Footer(){
        $this->SetFont('Times', 'B', 10); # Times
        $this->SetTextColor(255, 255, 255);
        $this->SetXY(5, $this->ALTURA_DATOS + $this->ALTURA_CELDA * 34);
        $this->SetFillColor(90, 90, 90);
        $this->Cell(15 + 35 + 15, $this->ALTURA_CELDA, utf8_decode(''), 1, 0, 'C', 1);

        $this->Cell(15, $this->ALTURA_CELDA, utf8_decode('TOTAL'), 1, 0, 'C', 1);
        $this->Cell(35, $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_BALDES ), 1, 0, 'C', 1);

        $this->Cell(20 + 20, $this->ALTURA_CELDA, utf8_decode(''), 1, 0, 'C', 1);

        $this->Cell(25, $this->ALTURA_CELDA, utf8_decode('TOTAL'), 1, 0, 'C', 1);
        $this->Cell(25, $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_PARA_PICAR ), 1, 0, 'C', 1);

        $this->Cell(25, $this->ALTURA_CELDA, utf8_decode(''), 1, 0, 'C', 1);
        $this->Cell(40, $this->ALTURA_CELDA, utf8_decode(''), 1, 0, 'C', 1);
    }

    public function SetTotalBaldes($val = ''){
        $this->TOTAL_BALDES = $val;
    }

    public function SetTotalParaPicar($val = ''){
        $this->TOTAL_PARA_PICAR = $val;
    }

    public function SetFechaReporte($val = ''){
        $this->FECHA_REPORTE = $val;
    }

    public function SetAnio($val =''){
        $this->ANIO_REPORTE = $val;
    }
    
}