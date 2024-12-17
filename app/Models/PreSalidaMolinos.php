<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreSalidaMolinos extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pre_salida_molino';

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
    protected $fillable = ['codigo', 'fecha', 'turno', 'id_encargado', 'proceso_id', 'observacion', 'baldes', 'cantidad','id_user', 'estado'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    /* function detalle_despachos()
    {
        return $this->hasMany(Detalle_despacho::class);
    }*/

    // Relación para el usuario receptor (receptor)
    public function recepcionista()
    {
        return $this->belongsTo(User::class, 'id_encargado');
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }
}
