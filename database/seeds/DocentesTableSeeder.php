<?php

use App\Docente;
use Illuminate\Database\Seeder;

class DocentesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Docente::class, 20)->create();

        factory(Docente::class)->create([
            'carnet' => 'NM100516',
            'dui' => '052360529',
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
