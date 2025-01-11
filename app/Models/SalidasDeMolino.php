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
        return $this->belongsTo(User::class, 'id_encargado');
    }

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }

    public function detalle_salida_molinos(){
        return $this->hasMany(DetalleSalidasDeMolino::class, 'salida_de_molino_id');
    }
    
}
