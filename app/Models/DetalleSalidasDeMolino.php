<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleSalidasDeMolino extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalle_salidas_de_molino';

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
    protected $fillable = ['salida_de_molino_id', 'detalle_proceso_preparacion_id', 'id_user', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    public function salida_molino()
    {
        return $this->belongsTo(SalidasDeMolino::class, 'salida_de_molino_id');
    }

    public function detalle_proceso_preparacion()
    {
        return $this->belongsTo(DetalleProcesoPreparacion::class, 'detalle_proceso_preparacion_id');
    }

    
}
