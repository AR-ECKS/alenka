<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDespachoIdToProcesosTable extends Migration
{
    public function up()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->unsignedBigInteger('despacho_id')->nullable();
            $table->foreign('despacho_id')->references('id')->on('despachos');
        });
    }

    public function down()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->dropForeign(['despacho_id']);
            $table->dropColumn('despacho_id');
        });
    }
}
