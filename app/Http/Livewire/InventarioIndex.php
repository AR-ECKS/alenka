<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\ProductosEnvasados;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

use App\Services\InventarioProductosEnvasadosService;

class InventarioIndex extends Component
{
    public $LISTA_DE_SABORES = [];
    public function mount(){
        $this->fechaActual = Carbon::now();#->isoFormat('YYYY-MM-DD');
        $this->anio = $this->fechaActual->isoFormat('YYYY');
        $this->mes = $this->fechaActual->isoFormat('MM');
        $this->dia = $this->fechaActual->isoFormat('DD');

        $this->statusMes = $this->statusDia = true;

        $this->LISTA_DE_SABORES = include(app_path(). '/dataCustom/sabores.php');
    }

    public function render()
    {
        return view('livewire.inventario-index', [
            'inventario_prod_envasados' => $this->get_data(),
            'list_anio' => $this->get_gestiones(),
            'list_mes' => $this->get_meses(),
            'list_dias' => $this->get_dias(),
        ]);
    }

    private function actualiza_fecha(){
        $this->fechaActual = Carbon::now();#->isoFormat('YYYY-MM-DD');
        $this->anio = $this->fechaActual->isoFormat('YYYY');
        $this->mes = $this->fechaActual->isoFormat('MM');
        $this->dia = $this->fechaActual->isoFormat('DD');
    }

    private function get_data(){
        $consulta = new InventarioProductosEnvasadosService($this->anio, $this->mes, $this->dia);
        $nada = $consulta->get_inventario();
        #$this->emit('mensaje', 'REG es: '. json_encode($nada));
        return $nada;
        /* $productos_envasados = ProductosEnvasados::select(
            'sabor',
            DB::raw("SUM(caja_cajas) AS total_cajas"),
            DB::raw("SUM(caja_bolsas) AS total_bolsas"),
        )
        ->where('estado', '<>', 0);
        if(!is_null($this->anio) && $this->anio !== "") {
            $productos_envasados->where( DB::raw("DATE_FORMAT(fecha, '%Y')"), $this->anio);
            if(!is_null($this->mes) && $this->mes !== ""){
                $productos_envasados->where( DB::raw("DATE_FORMAT(fecha, '%m')"), $this->mes);
                if(!is_null($this->dia) && $this->dia !== ""){
                    $productos_envasados->where( DB::raw("DATE_FORMAT(fecha, '%d')"), $this->dia);
                }
            }
        }
        $productos_envasados->groupBy('sabor');
        $productos_envasados->orderBy('sabor', 'ASC');
        return $productos_envasados->get(); */
    }

    public $anio = "";
    public $mes = "", $statusMes = false;
    public $dia = "", $statusDia = false;

    public function on_change_anio(){
        if($this->anio == ""){
            $this->mes = $this->dia = "";
            $this->statusMes = $this->statusDia = false;
        } else {
            $this->statusMes = true;
            $this->mes = $this->dia = "";
            $this->statusDia = false;
        }
    }

    public function on_change_mes(){
        if($this->mes == ""){
            $this->dia = "";
            $this->statusDia = false;
        } else {
            $this->statusDia = true;
            $this->dia = "";
        }
    }

    public function get_gestiones(){
        $gestionActual = $this->fechaActual->isoFormat('YYYY');
        $gestiones = ProductosEnvasados::select(
            DB::raw("DATE_FORMAT(fecha, '%Y') as anio")
        )
        ->union(
            DB::table(DB::raw("(SELECT '{$gestionActual}' as anio) as temporal"))
        )
        ->distinct()
        ->orderBy('anio')
        ->get();

        return $gestiones;
    }

    public function get_meses(){
        if($this->anio !== ""){
            $mesTemporal = $this->fechaActual->isoFormat('MM');
            $meses = ProductosEnvasados::select(
                DB::raw("DATE_FORMAT(fecha, '%m') as mes")
            )
            ->union(
                DB::table(DB::raw("(SELECT '{$mesTemporal}' as mes) as temporal"))
            )
            ->distinct()
            ->orderBy('mes');

            if(!is_null($this->anio) && $this->anio !== ""){
                $meses->where( DB::raw("DATE_FORMAT(fecha, '%Y')"), $this->anio);
            }
        return $meses->get();
        } else {
            return [];
        }
    }

    public function get_dias(){
        #$inicio = Carbon::createFromDate($this->fechaActual->isoFormat('YYYY'), $this->fechaActual->isoFormat('MM'), 1);
        if($this->anio !== "" && $this->mes!== ""){
            $inicio = Carbon::createFromDate($this->anio, $this->mes, 1);
            $fin = $inicio->copy()->endOfMonth();

            $todo = CarbonPeriod::create($inicio, $fin)->toArray();
            $dias = collect($todo)->map(function($fec) {
                return [
                    #'dia' => $fec->day,
                    'dia' => $fec->isoFormat('DD'),
                    'nombre' => $fec->locale('es')->isoFormat('dddd')
                ];
            });
            return $dias;
        } else{
            return [];
        }
    }

    public $operation = "";
}
