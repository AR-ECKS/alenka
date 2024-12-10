<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'compras';

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
    protected $fillable = ['numero_compra', 'factura', 'fecha', 'proveedor_id', 'observacion', 'user_id', 'forma_pago', 'total'];
    function user(){
        return $this->belongsTo(User::class);
    }


    function proveedor(){
        return $this->belongsTo(Proveedor::class,'proveedor_id');
    }

    function detallecompras(){
        return $this->hasMany(Detalle_compra::class);
    }
}
