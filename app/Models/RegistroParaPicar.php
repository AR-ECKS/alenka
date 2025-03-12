<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroParaPicar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'registro_para_picar';

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
    protected $fillable = ['codigo', 'sabor', 'observacion', 'encargado_id', 'user_id', 'fecha_inicio', 'fecha_fin', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function encargado()
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }

    function detalle_registros_para_picar(){
        return $this->hasMany(DetalleRegistroParaPicar::class)
            ->where('estado', '<>', 0);;
    }

    /* REVERSE */
    public function preparacion(){
        return $this->hasOne(ProcesoPreparacion::class, 'recepcion_para_picar_id')
            ->where('estado', '<>', 0);
    }

    /* attributes 
     * cantidad_kg
    */
    public function getCantidadKgAttribute() {
        $total = 0.00;
        foreach($this->detalle_registros_para_picar as $det_pic){
            $total += $det_pic->producto_envasado->para_picar_kg_de_bolsitas; # $det_pic->producto_envasado? $det_pic->producto_envasado->para_picar_kg_de_bolsitas;
        }
        return round($total, 2);
    }

    /* attributes 
     * cantidad_bolsitas
    */
    public function getCantidadBolsitasAttribute() {
        $total = 0;
        foreach($this->detalle_registros_para_picar as $det_pic){
            $total += $det_pic->producto_envasado->para_picar_nro_de_bolsitas; # $det_pic->producto_envasado? $det_pic->producto_envasado->para_picar_nro_de_bolsitas;
        }
        return $total;
    }
}
