<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->char('carnet', 8)->primary();
            $table->char('dui', 9)->unique();
            $table->string('foto', 200)->nullable();
            $table->string('primerNombre', 45);
            $table->string('segundoNombre', 45)->nullable();
            $table->string('tercerNombre', 45)->nullable();
            $table->string('apellidoPaterno', 45);
            $table->string('apellidoMaterno', 45);
            $table->enum('sexo', ['Femenino', 'Masculino']);
            $table->date('fechaNacimiento');
            $table->date('fechaIngreso');
            $table->boolean('estado')->default(true);
            // indices
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            // campos de auditoria
            $table->timestamps();
        });

        DB::connection()->getPdo()->exec(
            "
            CREATE TRIGGER docentes_BI BEFORE INSERT ON docentes FOR EACH ROW
            BEGIN
                DECLARE email varchar(255);
                DECLARE pass varchar(255);
                SET email = lower(concat(substring(NEW.primerNombre,1,1),NEW.apellidoPaterno,'.',lower(NEW.carnet),'@cra.edu.sv'));
                SET pass = substring(md5(rand()),-8);
                INSERT INTO users(usuario, email, password, tipo, created_at, updated_at) values(lower(NEW.carnet), email, pass, 'Docente', NEW.created_at, NEW.updated_at);
                SET NEW.user_id = (SELECT id FROM users WHERE usuario = lower(NEW.carnet));
                SET NEW.carnet = upper(NEW.carnet);
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
        Schema::dropIfExists('docentes');
        Storage::disk('public')->deleteDirectory('fotos/docentes');
    }
}
