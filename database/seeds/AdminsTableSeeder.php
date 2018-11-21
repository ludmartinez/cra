<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Admin::class, 3)->create();

        factory(Admin::class)->create([
            'carnet' => 'NM100500',
            'primerNombre' => 'Luis',
            'segundoNombre' => 'Diego',
            'tercerNombre' => null,
            'apellidoPaterno' => 'Navarrete',
            'apellidoMaterno' => 'Martínez',
            'sexo' => 'Masculino',
            'superUsuario' => true,
        ]);
    }
}
