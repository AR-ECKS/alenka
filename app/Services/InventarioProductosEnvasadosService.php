<?php

namespace App\Services;

use App\Models\ProductosEnvasados;

use Illuminate\Support\Facades\DB;

class InventarioProductosEnvasadosService
{
    protected $anio;
    protected $mes;
    protected $dia;

    public function __construct($anio = null, $mes = null, $dia = null)
    {
        $this->anio = $anio;
        $this->mes = $mes;
        $this->dia = $dia;
    }

    public function get_inventario()
    {
        $productos_envasados = ProductosEnvasados::select(
            'sabor',
            DB::raw("SUM(caja_cajas) AS total_cajas"),
            DB::raw("SUM(caja_bolsas) AS total_bolsas"),

            # codigo de producto
            DB::raw("
                CASE sabor
                    WHEN 'CHICLE' THEN 'PR-00008'
                    WHEN 'BANANA' THEN 'PR-00009'
                    WHEN 'FRUTILLA' THEN 'PR-00010'
                    WHEN 'CEDRÓN' THEN 'PR-00011'
                    WHEN 'CHIRIMOYA' THEN 'PR-00012'
                    WHEN 'DURAZNO' THEN 'PR-00013'
                    WHEN 'FUSIÓN DE FRUTAS' THEN 'PR-00015'
                    WHEN 'MANGO' THEN 'PR-00014'
                    WHEN 'MENTA' THEN 'PR-00003'

                    WHEN 'MARACUYÁ' THEN 'PR-00007'
                    WHEN 'MENTA 3 EN 1' THEN 'PR-00002'
                    WHEN 'CAFÉ 3 EN 1' THEN 'PR-00005'
                    WHEN 'LIMÓN' THEN 'PR-00006'
                    WHEN 'STEVIA' THEN 'PR-00001'
                    WHEN 'CAFÉ CANELA' THEN 'PR-00003'

                    ELSE 'PR-000??'
                END codigo_producto
            ")
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

        $res = $productos_envasados->get();
        $total_cajas = 0;
        $total_bolsitas = 0;
        foreach($res as $proc){
            if($proc->total_cajas){
                $total_cajas += $proc->total_cajas;
            }
            if($proc->total_bolsas){
                $total_bolsitas += $proc->total_bolsas;
            }
        }
        # si es mayor a 0, en la primera fila se incluye los totales finales
        if(count($res) > 0){
            $res[0]->final_total_cajas = $total_cajas;
            $res[0]->final_total_bolsas = $total_bolsitas;
        }
        return $res;
    }

}