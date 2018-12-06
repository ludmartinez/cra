<?php

use Illuminate\Database\Migrations\Migration;

class CreateStoredViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "DROP VIEW IF EXISTS historial_matriculas;
            CREATE VIEW historial_matriculas AS
            select p.periodo as periodo,
            nombre_completo(a.primerNombre, a.segundoNombre, a.tercerNombre, a.apellidoPaterno, a.apellidoMaterno) as alumno,
            edad(a.fechaNacimiento) as edad,
            a.sexo as sexo,
            g.grado as grado,
            if(a.solvencia = true, 'Solvente', 'Insolvente') as solvencia,
            tiempo_institucion(a.fechaIngreso) as tiempoInstitucion,
            m.created_at as fechaMatricula
            from matriculas as m
            inner join periodos as p
            on p.id = m.periodo_id
            inner join alumnos as a
            on a.carnet = m.alumno_carnet
            inner join grados as g
            on g.id = m.grado_id"
        );

        DB::connection()->getPdo()->exec(
            "DROP VIEW IF EXISTS historial_asignaciones;
            CREATE view historial_asignaciones as
            select p.periodo as periodo,
            nombre_completo(d.primerNombre, d.segundoNombre, d.tercerNombre, d.apellidoPaterno, d.apellidoMaterno) as docente,
            edad(d.fechaNacimiento) as edad,
            d.sexo as sexo,
            tiempo_institucion(d.fechaIngreso) as tiempoInstitucion,
            m.materia as materia,
            g.grado as grado
            from asignaciones as a
            inner join periodos as p
            on p.id =  a.periodo_id
            inner join docentes as d
            on d.carnet = a.docente_carnet
            inner join materias as m
            on m.id = a.materia_id
            inner join grados as g
            on g.id = a.grado_id"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::conection()->getPdo()->exec(
            "DROP VIEW historial_matriculas"
        );

        DB::conection()->getPdo()->exec(
            "DROP VIEW historial_asignaciones"
        );
    }
}
