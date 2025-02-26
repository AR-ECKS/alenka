<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleProcesoPreparacion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalle_proceso_preparacion';

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
    protected $fillable = [/* 'codigo', 'fecha', */ 'kg_balde', 'nro_balde', 'proceso_preparacion_id', 'observacion', 'id_user', 'estado'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    /* function detalle_despachos()
    {
        return $this->hasMany(Detalle_despacho::class);
    }*/

    // Relación para el usuario receptor (receptor)
    /* public function recepcionista()
    {
        return $this->belongsTo(User::class, 'id_encargado');
    } */

    public function proceso_preparacion()
    {
        return $this->belongsTo(ProcesoPreparacion::class, 'proceso_preparacion_id');
    }

    /* REVERSE */
    public function detalle_salida_de_molino(){
        return $this->hasOne(DetalleSalidasDeMolino::class, 'detalle_proceso_preparacion_id')
            ->where('estado', '<>', 0);;
    }
    
}
