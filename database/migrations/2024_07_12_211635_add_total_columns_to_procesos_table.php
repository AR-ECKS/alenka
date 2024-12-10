<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalColumnsToProcesosTable extends Migration
{
    public function up()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->integer('total_baldes');
            $table->integer('total_cantidad');
        });
    }

    public function down()
    {
        Schema::table('procesos', function (Blueprint $table) {
            $table->dropColumn('total_baldes');
            $table->dropColumn('total_cantidad');
        });
    }
}
