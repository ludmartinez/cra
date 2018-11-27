<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('periodo_id');
            $table->char('docente_carnet', 8);
            $table->unsignedInteger('grado_id');
            $table->unsignedInteger('materia_id');
            $table->timestamps();

            $table->foreign('periodo_id')
                ->references('id')->on('periodos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('grado_id')
                ->references('id')->on('grados')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('materia_id')
                ->references('id')->on('materias')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('docente_carnet')
                ->references('carnet')->on('docentes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaciones');
    }
}
