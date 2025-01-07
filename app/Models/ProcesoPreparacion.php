<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoPreparacion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proceso_preparacion';

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
    protected $fillable = ['codigo', 'fecha', 'total_kg', 'total_baldes', 'despacho_id', 'observacion', 'id_user', 'estado'];

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

    public function despacho()
    {
        return $this->belongsTo(Despacho::class, 'despacho_id');
    }

    function detalle_proceso_preparacion()
    {
        return $this->hasMany(DetalleProcesoPreparacion::class);
    }
}
