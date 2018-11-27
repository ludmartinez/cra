<?php

use Faker\Generator as Faker;

$factory->define(App\Matricula::class, function (Faker $faker) {
    $periodo_id = collect(App\Periodo::select('id')->get()->toArray())->flatten()->toArray();
    $carnet_alumno = collect(App\Alumno::select('carnet')->get()->toArray())->flatten()->toArray();
    $grado_id = collect(App\Grado::select('id')->get()->toArray())->flatten()->toArray();
    return [
        'periodo_id' => $faker->unique()->randomElement($periodo_id),
        'carnet_alumno' => $faker->unique()->randomElement($carnet_alumno),
        'grado_id' => $faker->randomElement($grado_id),
    ];
});
