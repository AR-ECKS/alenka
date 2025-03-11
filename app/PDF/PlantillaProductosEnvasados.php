<?php

namespace App\PDF;

use Codedge\Fpdf\Fpdf\Fpdf;

use Illuminate\Support\Str;

class PlantillaProductosEnvasados extends Fpdf {
    protected $TITULO = 'REGISTRO DE PRODUCTOS ENVASADOS ..../.../';
    private $borderDev = 0; # solo para desarrollo = 1

    public $ALTURA_DATOS = 44; # 44
    public $ALTURA_CELDA = 6.9;

    public $START_X = 9;

    public $MAX_FILAS = 20;

    private $DIA = '';
    private $MES = '';
    private $ANIO = '';

    private $TOTAL_SALDO_ANTERIOR = '';
    private $TOTAL_CAMBIO_MAQUINA = '';
    private $TOTAL_ENTRADA_MOLINO = '';
    private $TOTAL_SOBRO_DEL_DIA = '';
    private $TOTAL_CAJAS_CAJAS = '';
    private $TOTAL_CAJAS_BOLSAS = '';

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
        # insertar imagen
        $image = Str::finish(public_path(), DIRECTORY_SEPARATOR) . 'img' . DIRECTORY_SEPARATOR . 'logo.png'; #public_path(). '/img/logo.png';
        if(file_exists($image)){
            $this->Image($image, 10, 5, 0, 18);
            /* $this->Text(5, 5, 'Es'. $image); */
        }

        $this->Line($this->START_X_ATTR['COL_1']['X'], 8, 345, 8);

        $this->Line($this->START_X_ATTR['COL_1']['X'], 8, $this->START_X_ATTR['COL_1']['X'], 20);
        $this->Line(345, 8, 345, 20);

        $this->SetXY(30, 10);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 9, utf8_decode($this->TITULO), $this->borderDev, 1, 'C');

        # dia mes año
        $this->SetFont('Arial', '', 15);

        $this->SetXY(245, 10);
        $this->Cell(8, 7, utf8_decode($this->DIA), $this->borderDev, 1, 'C');

        $this->SetXY(253, 10);
        $this->Cell(7, 7, utf8_decode($this->MES), $this->borderDev, 1, 'C');

        $this->SetFont('Arial', 'B', 15);
        $this->SetXY(260, 10);
        $this->Cell(15, 7, utf8_decode($this->ANIO), $this->borderDev, 1, 'L');

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
        $this->SetFont('Times', 'B', 7); # Times

        $this->SetXY($this->START_X_ATTR['COL_16']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_16']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);
        $this->RotatedText($this->START_X_ATTR['COL_16']['X'] + 3, $ALTURA_HEAD + $ALTURA_TH - 7, utf8_decode('Problemas'), 90);
        $this->RotatedText($this->START_X_ATTR['COL_16']['X'] + 6, $ALTURA_HEAD + $ALTURA_TH - 7.5, utf8_decode('Máquina'), 90);

        $this->SetXY($this->START_X_ATTR['COL_17']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_17']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);
        $this->RotatedText($this->START_X_ATTR['COL_17']['X'] + 4.5, $ALTURA_HEAD + $ALTURA_TH - 6.5, utf8_decode('Operador'), 90);

        $this->SetXY($this->START_X_ATTR['COL_18']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_18']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);
        $this->RotatedText($this->START_X_ATTR['COL_18']['X'] + 4.5, $ALTURA_HEAD + $ALTURA_TH - 5, utf8_decode('Sin Novedad'), 90);

        $this->SetXY($this->START_X_ATTR['COL_19']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_19']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);
        $this->RotatedText($this->START_X_ATTR['COL_19']['X'] + 3, $ALTURA_HEAD + $ALTURA_TH - 6, utf8_decode('Cambio de'), 90);
        $this->RotatedText($this->START_X_ATTR['COL_19']['X'] + 6, $ALTURA_HEAD + $ALTURA_TH - 7, utf8_decode('Producto'), 90);

        $this->SetXY($this->START_X_ATTR['COL_20']['X'], $ALTURA_HEAD );
        $this->MultiCell($this->START_X_ATTR['COL_20']['WIDTH'], $ALTURA_TH, '', 1, 'C', $FILL_TH);
        $this->RotatedText($this->START_X_ATTR['COL_20']['X'] + 3, $ALTURA_HEAD + $ALTURA_TH - 7, utf8_decode('Producto'), 90);
        $this->RotatedText($this->START_X_ATTR['COL_20']['X'] + 6, $ALTURA_HEAD + $ALTURA_TH - 6, utf8_decode('Terminado'), 90);

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

    public function Footer(){

        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print centered page number
        $this->Cell(0, 10, 'página '.$this->PageNo(), 0, 0, 'C');

        $this->setFont('Arial', 'B', 9);
        $this->SetXY($this->START_X_ATTR['COL_3']['X'], $this->ALTURA_DATOS + $this->ALTURA_CELDA * $this->MAX_FILAS);
        $this->Cell($this->START_X_ATTR['COL_3']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( 'TOTALES' ), 1, 0, 'C');

        $this->Cell($this->START_X_ATTR['COL_4']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_SALDO_ANTERIOR ), 1, 0, 'C');
        $this->Cell($this->START_X_ATTR['COL_5']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_CAMBIO_MAQUINA ), 1, 0, 'C');
        $this->Cell($this->START_X_ATTR['COL_6']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_ENTRADA_MOLINO ), 1, 0, 'C');
        $this->Cell($this->START_X_ATTR['COL_7']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_SOBRO_DEL_DIA ), 1, 0, 'C');

        $this->Cell($this->START_X_ATTR['COL_8']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_CAJAS_CAJAS ), 1, 0, 'C');
        $this->Cell($this->START_X_ATTR['COL_9']['WIDTH'], $this->ALTURA_CELDA, utf8_decode( $this->TOTAL_CAJAS_BOLSAS ), 1, 0, 'C');
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

    public function SetTotalBaldeAnterior($val =''){
        $this->TOTAL_SALDO_ANTERIOR = $val;
    }
    public function SetTotalCambioMaquina($val =''){
        $this->TOTAL_CAMBIO_MAQUINA = $val;
    }
    public function SetTotalEntradaMolino($val =''){
        $this->TOTAL_ENTRADA_MOLINO = $val;
    }
    public function SetTotalSobroDelDia($val =''){
        $this->TOTAL_SOBRO_DEL_DIA = $val;
    }
    public function SetTotalCajasCajas($val =''){
        $this->TOTAL_CAJAS_CAJAS = $val;
    }
    public function SetTotalCajasBolsas($val =''){
        $this->TOTAL_CAJAS_BOLSAS = $val;
    }

    private function InicializaAnchoTabla(){
        $increment = $this->START_X;
        foreach($this->START_X_ATTR as $key => $data){
            $this->START_X_ATTR[$key]['X'] = $increment;
            $increment += $this->START_X_ATTR[$key]['WIDTH'];
        }
    }


    /* **************************************************** INIT SCRIPTS ************************************ */
    /* FIT TEXT TO CELL */
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max(strlen($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
    }
    /* ****************************************************************************************************** */
    /* ROTATIONS */
    var $angle=0;

    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    function _endpage()
    {
        if($this->angle!=0)
        {
            $this->angle=0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    function RotatedText($x,$y,$txt,$angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }

    function RotatedImage($file,$x,$y,$w,$h,$angle)
    {
        //Image rotated around its upper-left corner
        $this->Rotate($angle,$x,$y);
        $this->Image($file,$x,$y,$w,$h);
        $this->Rotate(0);
    }

    /* ****************************************************************************************************** */
    /* MULTI CELL WITH MAXLINE */
    function MultiCellTwo($w, $h, $txt, $border=0, $align='J', $fill=false, $maxline=0)
    {
        // Output text with automatic or explicit line breaks, at most $maxline lines
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw=$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',(string)$txt);
        $nb=strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b=0;
        if($border)
        {
            if($border==1)
            {
                $border='LTRB';
                $b='LRT';
                $b2='LR';
            }
            else
            {
                $b2='';
                if(is_int(strpos($border,'L')))
                    $b2.='L';
                if(is_int(strpos($border,'R')))
                    $b2.='R';
                $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
            }
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $ns=0;
        $nl=1;
        while($i<$nb)
        {
            // Get next character
            $c=$s[$i];
            if($c=="\n")
            {
                // Explicit line break
                if($this->ws>0)
                {
                    $this->ws=0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if($maxline && $nl>$maxline)
                    return substr($s,$i);
                continue;
            }
            if($c==' ')
            {
                $sep=$i;
                $ls=$l;
                $ns++;
            }
            $l+=$cw[$c];
            if($l>$wmax)
            {
                // Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                    }
                    $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                if($maxline && $nl>$maxline)
                {
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        $this->_out('0 Tw');
                    }
                    return substr($s,$i);
                }
            }
            else
                $i++;
        }
        // Last chunk
        if($this->ws>0)
        {
            $this->ws=0;
            $this->_out('0 Tw');
        }
        if($border && is_int(strpos($border,'B')))
            $b.='B';
        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
        $this->x=$this->lMargin;
        return '';
    }
    /* ****************************************************************************************************** */
    /* ***************************************************** END SCRIPTS ************************************ */
}