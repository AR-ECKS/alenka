<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'produccions';

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
    protected $fillable = ['codigo', 'fecha', 'proceso_id', 'user_id', 'sabor', 'observacion'];

    
}
