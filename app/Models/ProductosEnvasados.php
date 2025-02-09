<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductosEnvasados extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'productos_envasados';

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
    protected $fillable = ['sabor', 'codigo', 'fecha', 'salida_de_molino_id', 'encargado_id', 'observacion', 'maquina_id', 'balde_saldo_anterior', 'balde_entrada_de_molino','balde_sobro_del_dia', 'caja_cajas', 'caja_bolsas', 'estado'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    /* function detalle_despachos()
    {
        return $this->hasMany(Detalle_despacho::class);
    }*/

    public function encargado()
    {
        return $this->belongsTo(User::class, 'encargado_id');
    }

    public function salida_de_molino()
    {
        return $this->belongsTo(SalidasDeMolino::class, 'salida_de_molino_id');
    }

    public function maquina()
    {
        return $this->belongsTo(Maquina::class, 'maquina_id');
    }

    public function producto_saldo_anterior(){
        return $this->belongsTo(ProductosEnvasados::class, 'balde_saldo_anterior');
    }

}
