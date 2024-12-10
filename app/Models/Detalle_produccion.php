<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalle_produccion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'detalle_produccions';

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
    protected $fillable = ['produccion_id', 'user_id', 'baldes', 'cantidad'];

    
}
