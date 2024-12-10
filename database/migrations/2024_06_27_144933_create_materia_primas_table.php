<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaPrimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materia_primas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();

            $table->string('presentacion')->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('unidad_medida')->nullable();
            $table->integer('stock_presentacion')->nullable();
            $table->integer('stock_unidad')->nullable();
            $table->integer('stock_minimo')->nullable();
            $table->decimal('precio_compra', 10, 2)->nullable();
            $table->decimal('costo_unidad', 10, 2)->nullable();
            $table->string('imagen')->nullable();
            $table->tinyInteger('estado')->default('1');
            $table->integer('subcategoria_id')->unsigned();
            $table->foreign('subcategoria_id')->references('id')->on('subcategorias');
            $table->integer('proveedor_id')->unsigned();
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('materia_primas');
    }
}
