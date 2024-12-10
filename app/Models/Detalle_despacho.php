<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_despacho extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalle_despachos';

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
    protected $fillable = ['cantidad_presentacion', 'cantidad_unidad', 'materia_prima_id', 'despacho_id'];

    function despacho(){
        return $this->belongsTo(Despacho::class);
    }

    public function materia_prima()
    {
        return $this->belongsTo(Materia_Prima::class, 'materia_prima_id');
    }


}
