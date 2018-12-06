<?php

use Illuminate\Database\Migrations\Migration;

class CreateStoredFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->getPdo()->exec(
            "DROP FUNCTION IF EXISTS edad;
            CREATE FUNCTION edad(fecha_nacimiento DATE)
            RETURNS VARCHAR(10) DETERMINISTIC
            BEGIN
            DECLARE edad int;
            SET edad = TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE());
            RETURN concat(edad, ' años');
            END"
        );

        DB::connection()->getPdo()->exec(
            "DROP FUNCTION IF EXISTS tiempo_institucion;
            CREATE FUNCTION tiempo_institucion(ingreso DATE)
            RETURNS VARCHAR(10) DETERMINISTIC
            BEGIN
            DECLARE years int;
            SET years = TIMESTAMPDIFF(YEAR, ingreso, CURDATE());
            RETURN concat(years, ' años');
            END"
        );

        DB::connection()->getPdo()->exec(
            "DROP FUNCTION IF EXISTS nombre_completo;
            CREATE FUNCTION nombre_completo(nombre1 varchar(45), nombre2 varchar(45), nombre3 varchar(45),
            a_paterno varchar(45), a_materno varchar(45))
            RETURNS VARCHAR(225) DETERMINISTIC
            BEGIN
            DECLARE n1, n2, n3, a1, a2 VARCHAR(20);
            DECLARE nombre VARCHAR(60);
            SET n1 = TRIM(nombre1),
            n2 = TRIM(nombre2),
            n3 = TRIM(nombre3),
            a1 = TRIM(a_paterno),
            a2 = TRIM(a_materno);
            SET nombre = replace(replace(concat_ws(' ',n1,n2,n3,a1,a2), '  ', ' '), '  ', ' ');
            RETURN nombre;
            END"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::connection()->getPdo()->exec(
            "DROP FUNCTION edad"
        );

        DB::connection()->getPdo()->exec(
            "DROP FUNCTION tiempo_institucion"
        );

        DB::connection()->getPdo()->exec(
            "DROP FUNCTION nombre_completo"
        );
    }
}
