<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_compra extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalle_compras';

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
    protected $fillable = ['cantidad', 'precio_real_presentacion', 'precio_real_unidad_medida', 'materia_prima_id', 'compra_id'];



    function compra(){
        return $this->belongsTo(Compra::class);
    }

    function materia_prima(){
        return $this->belongsTo(Materia_prima::class);
    }


}
