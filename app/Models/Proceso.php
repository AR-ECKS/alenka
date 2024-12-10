<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'procesos';

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
    protected $fillable = ['codigo', 'observacion', 'fecha', 'despacho_id', 'user_id', 'baldes', 'incompleto', 'cantidad_incompleto', 'cantidad', 'total','total_baldes','total_cantidad'];

    function despacho(){
        return $this->belongsTo(Despacho::class);
    }
}
