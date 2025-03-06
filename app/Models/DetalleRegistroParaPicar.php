<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleRegistroParaPicar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalle_registro_para_picar';

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
    
    public function registro_para_picar()
    {
        return $this->belongsTo(RegistroParaPicar::class, 'registro_para_picar_id')
            ->where('estado', '<>', 0);
    }

    function producto_envasado(){
        return $this->belongsTo(ProductosEnvasados::class, 'producto_envasado_id')
            ->where('estado', '<>', 0);
    }
}
