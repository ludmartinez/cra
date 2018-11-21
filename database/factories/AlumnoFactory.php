<?php

use Faker\Generator as Faker;
use App\CustomHelpers\StringHelper;


$factory->define(App\Alumno::class, function (Faker $faker) {
    $sexo = $faker->randomElement($array = array('Femenino', 'Masculino'));
    $apellidoPaterno = $faker->lastName();
    $apellidoMaterno = $faker->lastName();
    if ($sexo == 'Femenino') {
        $primerNombre = $faker->firstName($gender = 'female');
        $segundoNombre = $faker->optional()->firstName($gender = 'female');
        if ($segundoNombre == null) {
            $tercerNombre = null;
        } else {
            $tercerNombre = $faker->optional()->firstName($gender = 'female');
        }
    } else {
        $primerNombre = $faker->firstName($gender = 'male');
        $segundoNombre = $faker->optional()->firstName($gender = 'male');
        if ($segundoNombre == null) {
            $tercerNombre = null;
        } else {
            $tercerNombre = $faker->optional()->firstName($gender = 'male');
        }
    }

    $carnet = str_limit($apellidoPaterno, 1, '');
    $carnet .= str_limit($apellidoMaterno, 1, '');
    $carnet .= $faker->unique()->numberBetween($min = 1000, $max = 9999);
    $carnet .= str_after(now()->year, 20);
    $carnet = StringHelper::str_withoutAccent($carnet);
    // dd($carnet);
    return [
        'carnet' => $carnet,
        'nie' => $faker->unique()->numberBetween($min = 10000000, $max = 99999999),
        'foto' => $faker->imageUrl(600, 800, 'people'),
        'primerNombre' => $primerNombre,
        'segundoNombre' => $segundoNombre,
        'tercerNombre' => $tercerNombre,
        'apellidoPaterno' => $apellidoPaterno,
        'apellidoMaterno' => $apellidoMaterno,
        'sexo' => $sexo,
        'fechaNacimiento' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'fechaIngreso' => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
