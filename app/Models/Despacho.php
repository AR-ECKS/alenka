<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Despacho extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'despachos';

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
    protected $fillable = ['codigo', 'sabor', 'observacion', 'fecha', 'receptor', 'user_id', 'salida_esperada', 'total','tipo'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function detalle_despachos(): HasMany
    {
        return $this->hasMany(Detalle_despacho::class, 'despacho_id');
    }

    /* public function totalKgAprox(): Attribute {
        $mater = $this->hasMany(Detalle_despacho::class, 'despacho_id');
        $total = 0;
        if($mater){
            foreach ($mater as $key => $value) {
                $total += $value->cantidad_unidad;
            }
        }
        return $total;
    } */

    // Relación para el usuario receptor (receptor)
    public function receptor_u()
    {
        return $this->belongsTo(User::class, 'receptor');
    }
}
