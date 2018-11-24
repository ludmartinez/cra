<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('periodo_id');
            $table->char('alumno_carnet', 8);
            $table->unsignedInteger('grado_id');
            $table->timestamps();

            $table->foreign('periodo_id')
                ->references('id')->on('periodos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('alumno_carnet')
                ->references('carnet')->on('alumnos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('grado_id')
                ->references('id')->on('grados')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}
