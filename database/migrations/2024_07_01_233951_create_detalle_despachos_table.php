<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleDespachosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_despachos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('cantidad_presentacion')->nullable();
            $table->string('cantidad_unidad')->nullable();
            $table->integer('materia_prima_id')->unsigned();
            $table->foreign('materia_prima_id')->references('id')->on('materia_primas');
            $table->integer('despacho_id')->unsigned();
            $table->foreign('despacho_id')->references('id')->on('despachos');
            $table->tinyInteger('estado')->default('1');

            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('detalle_despachos');
    }
}
