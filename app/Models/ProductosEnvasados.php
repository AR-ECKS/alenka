<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProductosEnvasados extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'productos_envasados';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['sabor', 'codigo', 'fecha', 'salida_de_molino_id', 'encargado_id', 'observacion', 'maquina_id', 'balde_saldo_anterior', 'balde_entrada_de_molino','balde_sobro_del_dia', 'caja_cajas', 'caja_bolsas', 'estado'];

    protected $CAJA_KG = 2.4;
    protected $BOLSITA_KG = .012;

    function user()
    {
        return $this->belongsTo(User::class);
    }

    /* function detalle_despachos()
    {
        return $this->hasMany(Detalle_despacho::class);
    }*/

    public function encargado()
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }

    /* public function salida_de_molino()
    {
        return $this->belongsTo(SalidasDeMolino::class, 'salida_de_molino_id');
    } */

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }

    public function producto_saldo_anterior(){
        return $this->belongsTo(ProductosEnvasados::class, 'balde_saldo_anterior');
    }

    public function producto_cambio_de_maquina(){
        return $this->belongsTo(ProductosEnvasados::class, 'balde_cambio_de_maquina_id');
    }

    /* REVERSE */

    public function salidas_de_molino(){
        return $this->hasMany(SalidasDeMolino::class, 'producto_envasado_id')
            ->where('estado', '<>', 0);
    }

    public function cambio_maquina_descuento(){
        return $this->hasOne(ProductosEnvasados::class, 'balde_cambio_de_maquina_id');
    }

    /* attributes 
     * entrada_cantidad_de_baldes
    */
    public function getEntradaCantidadDeBaldesAttribute() {
        $total = 0;
        foreach($this->salidas_de_molino as $sal_mol){
            $total += count($sal_mol->detalle_salida_molinos);
        }
        return $total;
    }

    /* attributes 
     * entrada_cantidad_kg
    */
    public function getEntradaCantidadKgAttribute() {
        $total = 0.00;
        if($this->entrada_cantidad_de_baldes > 0){
            foreach($this->salidas_de_molino as $sal_mol){
                foreach($sal_mol->detalle_salida_molinos as $val_det){
                    $total += $val_det->detalle_proceso_preparacion->kg_balde;
                }
            }
        }
        return round($total, 2);
    }

    /* attributes 
     * cantidad_kg_de_caja
    */
    public function getCantidadKgDeCajaAttribute(){
        $total = 0.00;
        if($this->caja_cajas){
            $total = $this->caja_cajas * $this->CAJA_KG;
        }
        return round($total, 2);
    }

    /* attributes 
     * cantidad_kg_de_bolsitas
    */
    public function getCantidadKgDeBolsitasAttribute(){
        $total = 0.00;
        if($this->caja_cajas){
            $total = $this->caja_bolsas * $this->BOLSITA_KG;
        }
        return round($total, 2);
    }

    /* atributos para determinar la disponiblidad 
     * alk_total_baldes: la suma total de 'entrada de molino', 'saldo anterior' y 'cambio de maquina'
     * alk_total_kg: la suma total de 'entrada de molino' y 'saldo anterior' y y 'cambio de maquina'
     * alk_disponible_baldes: la suma total de 'entrada de molino', 'saldo anterior' y 'cambio de maquina' menos 'sobro del dia' y 'cajas, cajas'
     * alk_disponible_kg: la suma total de 'entrada de molino', 'saldo anterior' y 'cambio de maquina' menos 'sobro del dia' y 'cajas y cajas'
     * */

    public function getAlkTotalBaldesAttribute(){
        $total = 0;
        # añadir las entradas de molino
        $total += $this->entrada_cantidad_de_baldes;
        # añadir los saldos anteriores
        if($this->producto_saldo_anterior){
            $total += $this->producto_saldo_anterior->balde_sobro_del_dia;
        }
        # añadir los cambios de máquina
        if($this->producto_cambio_de_maquina){
            $total += $this->balde_cambio_de_maquina_baldes;
        }
        return round($total, 2);
    }
    
    public function getAlkTotalKgAttribute(){
        $total = 0;
        # añadir las entradas de molino
        $total += $this->entrada_cantidad_kg;
        # añadir los saldos anteriores
        if($this->producto_saldo_anterior){
            $total += $this->producto_saldo_anterior->balde_sobro_del_dia_kg;
        }
        # se debería pesar, antes de procesar los saldos anteriores o sino calcular, segun la formula

        # añadir los cambios de maquina
        if($this->producto_cambio_de_maquina){
            $total += $this->balde_cambio_de_maquina_kg;
        }
        return $total;
    }

    public function getAlkDisponibleBaldesAttribute(){
        $total = $this->alk_total_baldes;
        # restar las sobras del dia
        if($this->balde_sobro_del_dia){
            $total -= $this->balde_sobro_del_dia;
        }
        # restar los tranferidos a otras maquinas
        if($this->cambio_maquina_descuento){
            $total -= $this->cambio_maquina_descuento->balde_cambio_de_maquina_baldes;
        }
        # restar las cajas
        return round($total, 2);
    }

    public function getAlkDisponibleKgAttribute(){
        $total = 0;
        $total += $this->alk_total_kg;
        # restar las sobras del dia
        if($this->balde_sobro_del_dia){
            $total -= $this->balde_sobro_del_dia_kg;
        }
        # se debería pesar, antes de procesar los saldos anteriores o sino calcular, segun la formula

        # restar los tranferidos a otras maquinas
        if($this->cambio_maquina_descuento){
            $total -= $this->cambio_maquina_descuento->balde_cambio_de_maquina_kg;
        }
        # restar las cajas
        $total -= $this->cantidad_kg_de_caja;

        # restar las bolsitas 
        $total -= $this->cantidad_kg_de_bolsitas;

        # restar los 'para picar'
        if($this->para_picar == 1){
            $total -= $this->para_picar_kg_de_bolsitas;
        }
        return round($total, 2);
    }

}
