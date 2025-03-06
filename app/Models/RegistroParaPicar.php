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
}
