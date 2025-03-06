<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalidasDeMolino extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'salidas_de_molino';

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
    protected $fillable = ['codigo', 'fecha', 'turno', 'encargado_id', 'maquina_id', 'sabor', 'observacion', 'total_aprox', 'id_user', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function recepcionista()
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }

    public function detalle_salida_molinos(){
        return $this->hasMany(DetalleSalidasDeMolino::class, 'salida_de_molino_id')
            ->where('estado', '<>', 0);
    }

    public function producto_envasado(){
        return $this->belongsTo(ProductosEnvasados::class, 'producto_envasado_id');
    }

    /* attributes 
     * cantidad_baldes
    */
    public function getCantidadBaldesAttribute(){
        return count($this->detalle_salida_molinos);
    }

    /* attributes 
     * cantidad_kg
    */
    public function getCantidadKgAttribute(){
        $total = 0.00;
        if($this->cantidad_baldes > 0){
            foreach($this->detalle_salida_molinos as $sal_mol){
                $total += $sal_mol->detalle_proceso_preparacion->kg_balde;
            }
        }
        return round($total, 2);
    }

    /* REVERSE */
    /* public function producto_envasado(){
        return $this->hasOne(ProductosEnvasados::class, 'salida_de_molino_id');
    }
     */
}
