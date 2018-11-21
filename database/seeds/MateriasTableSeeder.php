<?php

use App\Materia;
use Illuminate\Database\Seeder;

class MateriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Materia::class, 10)->create();
    }
}
