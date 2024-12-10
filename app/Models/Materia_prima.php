<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia_prima extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'materia_primas';

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
    protected $fillable = ['codigo', 'nombre', 'descripcion', 'subcategoria_id', 'proveedor_id', 'presentacion', 'cantidad', 'unidad_medida', 'stock_unidad','stock_presentacion', 'stock_minimo', 'precio_compra', 'costo_unidad', 'imagen'];

    public function subcategoria()
    {
        return $this->belongsTo(Subcategorium::class, 'subcategoria_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }


    function detallecompras(){
        return $this->hasMany(Detalle_compra::class);
    }
}
