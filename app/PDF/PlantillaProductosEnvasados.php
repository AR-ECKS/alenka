<?php

namespace App\PDF;

use Codedge\Fpdf\Fpdf\Fpdf;

class PlantillaProductosEnvasados extends Fpdf {
    protected $TITULO = 'REGISTRO DE PRODUCTOS ENVASADOS ..../.../';
    private $borderDev = 1; # solo para desarrollo = 1

    public $ALTURA_DATOS = 38;
    public $ALTURA_CELDA = 4.9;

    public $START_X = 9;

    private $DIA = '';
    private $MES = '';
    private $ANIO = '';

    public $DATA_START_X_ATTRIBUTES = [
        'COL_1' => 9,
        'COL_2' => 21,
        'COL_3' => 50,
        'COL_4' => 70,
    ];



    function __construct(){
        parent::__construct('L', 'mm', 'Legal'); #oficio = Legal

        $this->SetFillColor(50, 255, 50);
        $this->SetFont('Arial', 'B', 12);
        $this->SetAutopageBreak(false, 0);
    }

    public function Header(){

        $this->Line($this->START_X, 8, 345, 8);

        $this->Line($this->START_X, 8, $this->START_X, 20);
        $this->Line(345, 8, 345, 20);

        $this->SetXY(30, 10);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 9, utf8_decode($this->TITULO), $this->borderDev, 1, 'C');

        $this->SetXY(30, 19);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(90, 5, utf8_decode('MES: '. str_pad('', 60, '.')), $this->borderDev, 1, 'L');

        $this->SetXY(40, 18.4);
        $this->SetFont('Arial', '',10);
        $this->Cell(80, 5, utf8_decode($this->DIA), $this->borderDev, 1, 'L');

        # ENCABEZADOS thead > th

        $ALTURA_HEAD = 20;
        $ALTURA_TH = 24;
        $this->SetFont('Times', 'B', 10); # Times
        $this->SetTextColor(0, 0, 0);
        $this->SetXY($this->START_X, $ALTURA_HEAD);
        $this->SetFillColor(240, 240, 240);
        $this->Cell(12, $ALTURA_TH, utf8_decode('MAQ.'), 1, 0, 'C', 1);
        $this->Cell(29, $ALTURA_TH, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
        $this->Cell(30, $ALTURA_TH, utf8_decode('SABOR'), 1, 0, 'C', 1);
        $this->MultiCell(35, $ALTURA_TH /2 , utf8_decode('NOMBRE'), 1, 'C', 1);

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
}