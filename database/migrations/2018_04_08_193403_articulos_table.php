<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function(Blueprint $table)
        {
            $table->string('codigo');
            $table->string('nombre');
            $table->increments('idarticulo');
            $table->string('descripcion');
            $table->integer('stock');
            $table->string('estado');
            $table->string('imagen');
            $table->float('precio_venta');
            $table->integer('idcategoria')->unsigned();
            $table->foreign('idcategoria')->references('idcategoria')->on('idcategoria')->ondelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articulos');
    }
}
