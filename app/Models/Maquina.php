<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'maquinas';

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
    protected $fillable = ['nombre', 'descripcion', 'id_user', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }


    /* function detallecompras(){
        return $this->hasMany(Detalle_compra::class);
    } */
}
