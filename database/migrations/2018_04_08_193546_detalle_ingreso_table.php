<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DetalleIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ingreso', function(Blueprint $table)
        {
            $table->increments('iddetalle_ingreso');
            $table->integer('cantidad');
            $table->float('precio_compra');
            $table->integer('idingreso')->unsigned();
            $table->foreign('idingreso')->references('idingreso')->on('ingresos')->ondelete('cascade');
            $table->integer('idarticulo')->unsigned();
            $table->foreign('idarticulo')->references('idarticulo')->on('articulos')->ondelete('cascade');            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('detalle_ingreso');
    }
}
