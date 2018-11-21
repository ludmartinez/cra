<?php

use App\Alumno;
use Illuminate\Database\Seeder;

class AlumnosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Alumno::class, 200)->create();

        factory(Alumno::class)->create([
            'carnet' => 'NM100515',
            'primerNombre' => 'Luis',
            'segundoNombre' => 'Diego',
            'tercerNombre' => null,
            'apellidoPaterno' => 'Navarrete',
            'apellidoMaterno' => 'Martínez',
            'sexo' => 'Masculino',
            'fechaNacimiento' => '1995-09-08',
        ]);
    }
}
