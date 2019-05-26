<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direcciones', function (Blueprint $table) {
            $table->increments('id');
            $table->text('direccion');

            //Índice
            $table->unsignedInteger('id_departamento');
            $table->unsignedInteger('id_municipio');
            $table->foreign('id_departamento')
                ->references('id')->on('departamentos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('id_municipio')
                ->references('id')->on('municipios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direccions');
    }
}
