<?php

use App\CustomHelpers\StringHelper;
use App\User;
use Faker\Generator as Faker;

$factory->define(App\Admin::class, function (Faker $faker) {
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
    return [
        'carnet' => $carnet,
        'dui' => $faker->unique()->numberBetween($min = 100000000, $max = 999999999),
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

$factory->afterCreating(App\Admin::class, function ($admin, $faker) {
    $admin->refresh();
    $usuario = $admin->user;
    $usuario->password = bcrypt($usuario->password);
    $usuario->save();
});
